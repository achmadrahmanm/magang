<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\BusinessField;
use App\Models\Lecturer;
use App\Models\User;
use App\Models\UserSignature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Barryvdh\DomPDF\Facade\Pdf;

class DosenController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Get application statistics
        $totalApplications = Application::count();
        $approvedApplications = Application::where('status', 'approved')->count();
        $pendingApplications = Application::where('status', 'submitted')->count();
        $rejectedApplications = Application::where('status', 'rejected')->count();

        // Get recent applications
        $recentApplications = Application::with(['submittedBy', 'members.student'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboards.dosen', compact(
            'totalApplications',
            'approvedApplications',
            'pendingApplications',
            'rejectedApplications',
            'recentApplications'
        ));
    }

    public function applications(Request $request)
    {
        $query = Application::with(['submittedBy', 'members.student'])->whereNotIn('status', ['draft']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('institution_name', 'like', "%{$search}%")
                    ->orWhereHas('company', function ($companyQuery) use ($search) {
                        $companyQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('submittedBy', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('members.student', function ($studentQuery) use ($search) {
                        $studentQuery->where('nama_resmi', 'like', "%{$search}%");
                    });
            });
        }

        $applications = $query->latest()->paginate(15);

        return view('dosen.applications', compact('applications'));
    }

    public function showApplication(Application $application)
    {
        $application->load(['submittedBy', 'members.student', 'documents', 'businessField']);
        return view('dosen.application-detail', compact('application'));
    }

    
    public function approveApplication(Application $application)
    {
        $application->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now()
        ]);

        return redirect()->back()->with('success', 'Application approved successfully.');
    }

    public function rejectApplication(Application $application)
    {
        $application->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now()
        ]);

        return redirect()->back()->with('success', 'Application rejected.');
    }

    public function showAvailableReviewers()
    {
        $reviewers = Lecturer::with(['user.identity'])
            ->whereHas('user', function ($query) {
                $query->where('role', 'dosen');
            })
            ->get()
            ->map(function ($lecturer) {
                $user = $lecturer->user;
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->identity && $user->identity->image ? $user->identity->image_url : null,
                ];
            });

        return response()->json([
            'success' => true,
            'reviewers' => $reviewers,
        ]);
    }

    public function chooseReviewer(Request $request, Application $application)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
        ]);

        // Check if reviewer is a dosen
        $reviewer = User::where('id', $request->reviewer_id)->where('role', 'dosen')->first();
        if (!$reviewer) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reviewer selected.',
            ], 422);
        }

        // Update application
        $application->update([
            'reviewed_by' => $request->reviewer_id,
            'status' => 'reviewing',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reviewer assigned successfully. Application status changed to reviewing.',
        ]);
    }


    public function downloadApplication(Application $application)
    {
        // Implementation for downloading application files
        // This would depend on how files are stored
        return response()->download($application->file_path);
    }

    public function approvals()
    {
        $user = Auth::user();

        // Get all reviewed applications by this dosen
        $reviewedApplications = Application::with(['submittedBy', 'members.student', 'businessField'])
            ->where('reviewed_by', $user->id)
            ->whereIn('status', ['approved', 'rejected', 'reviewing'])
            ->latest('reviewed_at')
            ->get();

        // Statistics
        $totalReviewed = $reviewedApplications->count();
        $totalApproved = $reviewedApplications->where('status', 'approved')->count();
        $totalRejected = $reviewedApplications->where('status', 'rejected')->count();
        $totalReviewing = $reviewedApplications->where('status', 'reviewing')->count();
        $approvedThisMonth = $reviewedApplications->where('status', 'approved')
            ->where('reviewed_at', '>=', now()->startOfMonth())->count();
        $successRate = ($totalApproved + $totalRejected) > 0 ? round(($totalApproved / ($totalApproved + $totalRejected)) * 100, 1) : 0;

        // Recent review activity (last 10)
        $recentReviews = $reviewedApplications->take(10);

        return view('dosen.approvals', compact(
            'reviewedApplications',
            'totalReviewed',
            'totalApproved',
            'totalRejected',
            'totalReviewing',
            'approvedThisMonth',
            'successRate',
            'recentReviews'
        ));
    }

    public function settings()
    {
        return view('dosen.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
        ]);

        Auth::user()->update($request->only(['name', 'email', 'phone', 'department']));

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        // Implementation for notification preferences
        // This would typically update user preferences in a separate table
        return redirect()->back()->with('success', 'Notification preferences updated.');
    }

    public function updatePreferences(Request $request)
    {
        // Implementation for application preferences
        // This would typically update user preferences
        return redirect()->back()->with('success', 'Preferences updated successfully.');
    }


    /**
     * Show signature page
     */
    public function showSignaturePage()
    {
        $user = Auth::user();
        $activeSignature = $user->activeSignature;
        $allSignatures = $user->signatures()->latest()->get();

        return view('dosen.signature', [
            'activeSignature' => $activeSignature,
            'allSignatures' => $allSignatures,
        ]);
    }

    /**
     * Save signature
     */
    public function saveSignature(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'signature_data' => 'required|string',
                'purpose' => 'nullable|string|max:100',
                'notes' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Data tidak valid',
                        'errors' => $validator->errors(),
                    ],
                    422,
                );
            }

            $user = Auth::user();
            $signatureData = $request->signature_data;

            // Validate base64 image
            if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $signatureData)) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Format signature tidak valid',
                    ],
                    422,
                );
            }

            // Extract base64 data
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $signatureData);
            $imageData = base64_decode($imageData);

            if ($imageData === false) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Gagal memproses data signature',
                    ],
                    422,
                );
            }

            // Generate filename
            $filename = 'signature_' . $user->id . '_' . time() . '.png';
            $path = 'user_signatures/' . $filename;

            // Save file to storage
            Storage::disk('public')->put($path, $imageData);

            // Deactivate previous signatures
            UserSignature::where('user_id', $user->id)->update(['is_active' => false]);

            // Create new signature record
            $signature = UserSignature::create([
                'user_id' => $user->id,
                'signature_path' => $path,
                'original_filename' => $filename,
                'file_type' => 'png',
                'file_size' => strlen($imageData),
                'signature_data' => ['base64' => $signatureData],
                'is_active' => true,
                'purpose' => $request->purpose ?? 'general',
                'notes' => $request->notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Signature berhasil disimpan',
                'signature' => [
                    'id' => $signature->id,
                    'url' => $signature->signature_url,
                    'created_at' => $signature->created_at->format('d M Y H:i'),
                    'file_size' => $signature->formatted_file_size,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saving signature', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan signature',
                ],
                500,
            );
        }
    }

    /**
     * Get user signatures
     */
    public function getUserSignatures()
    {
        try {
            $user = Auth::user();
            $signatures = $user->signatures()->latest()->get();

            $formattedSignatures = $signatures->map(function ($signature) {
                return [
                    'id' => $signature->id,
                    'url' => $signature->signature_url,
                    'purpose' => $signature->purpose,
                    'notes' => $signature->notes,
                    'is_active' => $signature->is_active,
                    'file_size' => $signature->formatted_file_size,
                    'created_at' => $signature->created_at->format('d M Y H:i'),
                ];
            });

            return response()->json([
                'success' => true,
                'signatures' => $formattedSignatures,
                'total' => $signatures->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal mengambil data signature',
                ],
                500,
            );
        }
    }

    /**
     * Delete signature
     */
    public function deleteSignature($signatureId)
    {
        try {
            $signature = UserSignature::where('id', $signatureId)->where('user_id', Auth::id())->first();

            if (!$signature) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Signature tidak ditemukan',
                    ],
                    404,
                );
            }

            // Delete file from storage
            if ($signature->signature_path && Storage::disk('public')->exists($signature->signature_path)) {
                Storage::disk('public')->delete($signature->signature_path);
            }

            // Delete record
            $signature->delete();

            return response()->json([
                'success' => true,
                'message' => 'Signature berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal menghapus signature',
                ],
                500,
            );
        }
    }

    /**
     * Set active signature
     */
    public function setActiveSignature($signatureId)
    {
        try {
            $user = Auth::user();

            // Check if signature belongs to user
            $signature = UserSignature::where('id', $signatureId)->where('user_id', $user->id)->first();

            if (!$signature) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Signature tidak ditemukan',
                    ],
                    404,
                );
            }

            // Deactivate all signatures
            UserSignature::where('user_id', $user->id)->update(['is_active' => false]);

            // Activate selected signature
            $signature->update(['is_active' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Signature aktif berhasil diubah',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal mengubah signature aktif',
                ],
                500,
            );
        }
    }

    /**
     * Download signature file
     */
    public function downloadSignature($signatureId)
    {
        try {
            $signature = UserSignature::where('id', $signatureId)->where('user_id', Auth::id())->first();

            if (!$signature) {
                abort(404, 'Signature tidak ditemukan');
            }

            if (!$signature->signature_path || !Storage::disk('public')->exists($signature->signature_path)) {
                abort(404, 'File signature tidak ditemukan');
            }

            return Storage::disk('public')->download($signature->signature_path, 'signature_' . Auth::user()->name . '_' . $signature->id . '.png');
        } catch (\Exception $e) {
            \Log::error('Error downloading signature', [
                'signature_id' => $signatureId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengunduh signature');
        }
    }

    /**
     * View application PDF inline
     */
    public function viewApplication(Application $application)
    {
        try {
            // Check if application has a reviewer assigned
            if (!$application->reviewed_by) {
                abort(403, 'Application belum memiliki reviewer yang ditunjuk');
            }

            // Load application with necessary relationships
            $application->load(['submittedBy', 'members.student', 'documents', 'businessField', 'reviewedBy.lecturer']);

            // Get reviewer details
            $reviewer = $application->reviewedBy;
            $lecturer = $reviewer->lecturer;

            // Get reviewer's active signature
            $approverSignature = $reviewer->activeSignature;
            $approverName = $lecturer ? $lecturer->nama_resmi : $reviewer->name;
            $approverNip = $lecturer ? $lecturer->nip : null;

            // Generate PDF
            $pdf = Pdf::loadView('pdf.proposal', [
                'application' => $application,
                'signature' => $approverSignature,
                'approverName' => $approverName,
                'approverNip' => $approverNip,
            ]);

            // Set paper size and orientation
            $pdf->setPaper('a4', 'portrait');

            // Return PDF as stream (inline display)
            return $pdf->stream('Surat_Pengantar_Proposal_APP-' . $application->id . '.pdf');
        } catch (\Exception $e) {
            \Log::error('Error generating application PDF', [
                'application_id' => $application->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            abort(500, 'Gagal menghasilkan PDF aplikasi');
        }
    }

}
