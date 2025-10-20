<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\UserSignature;

class MahasiswaController extends Controller
{
    /**
     * Display the formal request form
     */
    public function showFormalRequestForm()
    {
        return view('mahasiswa.form_formalrequests');
    }

    /**
     * Store the internship proposal
     */
    public function storeProposal(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'topic' => 'required|string|max:255',
                'company' => 'required|string|max:255',
                'company_address' => 'required|string|max:1000',
                'business_field' => 'required|string|max:100',
                'department' => 'required|string|max:255',
                'division' => 'nullable|string|max:255',
                'start_date' => 'required|date|after:today',
                'duration' => 'required|integer|min:1|max:12',
                'proposal_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
                'members' => 'required|array|min:1|max:4',
                'members.*.student_id' => 'required|string|max:20',
                'members.*.name' => 'required|string|max:255',
                'members.*.email' => 'required|email|max:255',
                'members.*.year' => 'required|integer|min:2015|max:2030',
                'agreement' => 'required|accepted'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
            }

            // Handle file upload
            $proposalPath = null;
            if ($request->hasFile('proposal_file')) {
                $file = $request->file('proposal_file');
                $filename = 'proposal_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $proposalPath = $file->storeAs('proposals', $filename, 'public');
            }

            // Generate unique proposal ID
            $proposalId = 'PROP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Mock data structure (in real app, this would be saved to database)
            $proposalData = [
                'id' => $proposalId,
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'user_email' => Auth::user()->email,
                'topic' => $request->topic,
                'company' => $request->company,
                'company_address' => $request->company_address,
                'business_field' => $request->business_field,
                'department' => $request->department,
                'division' => $request->division,
                'start_date' => $request->start_date,
                'duration' => $request->duration,
                'proposal_file_path' => $proposalPath,
                'members' => $request->members,
                'status' => 'submitted',
                'submitted_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Store in session for demo purposes (in real app, save to database)
            $existingProposals = session('user_proposals', []);
            $existingProposals[] = $proposalData;
            session(['user_proposals' => $existingProposals]);

            // Log the submission (mock)
            \Log::info('Internship Proposal Submitted', [
                'proposal_id' => $proposalId,
                'user_id' => Auth::id(),
                'company' => $request->company,
                'members_count' => count($request->members),
                'file_size' => $request->file('proposal_file')->getSize()
            ]);

            return redirect()
                ->route('mahasiswa.formal-requests')
                ->with('success', "Proposal berhasil disubmit! ID Proposal: {$proposalId}")
                ->with('proposal_id', $proposalId);

        } catch (\Exception $e) {
            \Log::error('Error submitting proposal', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan proposal. Silakan coba lagi.');
        }
    }

    /**
     * Save proposal as draft
     */
    public function saveDraft(Request $request)
    {
        try {
            $draftId = 'DRAFT-' . Auth::id() . '-' . time();
            
            // Mock draft storage
            $draftData = [
                'id' => $draftId,
                'user_id' => Auth::id(),
                'data' => $request->except(['_token', 'proposal_file']),
                'status' => 'draft',
                'saved_at' => now()
            ];

            // Handle file upload for draft if exists
            if ($request->hasFile('proposal_file')) {
                $file = $request->file('proposal_file');
                $filename = 'draft_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $draftData['proposal_file_path'] = $file->storeAs('drafts', $filename, 'public');
            }

            // Store draft in session
            session(['proposal_draft' => $draftData]);

            return response()->json([
                'success' => true,
                'message' => 'Draft berhasil disimpan',
                'draft_id' => $draftId,
                'saved_at' => now()->format('d M Y H:i')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan draft: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get proposal list
     */
    public function getProposals()
    {
        $proposals = session('user_proposals', []);
        $draft = session('proposal_draft');
        
        return response()->json([
            'proposals' => $proposals,
            'draft' => $draft,
            'total' => count($proposals)
        ]);
    }

    /**
     * Download proposal file
     */
    public function downloadProposal($proposalId)
    {
        try {
            // Find proposal in session data
            $proposals = session('user_proposals', []);
            $proposal = collect($proposals)->firstWhere('id', $proposalId);

            if (!$proposal) {
                abort(404, 'Proposal tidak ditemukan');
            }

            // Check if user owns this proposal
            if ($proposal['user_id'] !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke proposal ini');
            }

            if (!$proposal['proposal_file_path'] || !Storage::disk('public')->exists($proposal['proposal_file_path'])) {
                abort(404, 'File proposal tidak ditemukan');
            }

            return Storage::disk('public')->download(
                $proposal['proposal_file_path'],
                'Proposal_' . $proposal['company'] . '_' . $proposal['id'] . '.pdf'
            );

        } catch (\Exception $e) {
            \Log::error('Error downloading proposal', [
                'proposal_id' => $proposalId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Gagal mengunduh file proposal');
        }
    }

    /**
     * Preview proposal file
     */
    public function previewProposal($proposalId)
    {
        try {
            $proposals = session('user_proposals', []);
            $proposal = collect($proposals)->firstWhere('id', $proposalId);

            if (!$proposal || $proposal['user_id'] !== Auth::id()) {
                abort(404);
            }

            if (!$proposal['proposal_file_path'] || !Storage::disk('public')->exists($proposal['proposal_file_path'])) {
                abort(404, 'File tidak ditemukan');
            }

            $filePath = Storage::disk('public')->path($proposal['proposal_file_path']);
            
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="proposal_preview.pdf"'
            ]);

        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Delete proposal (for testing purposes)
     */
    public function deleteProposal($proposalId)
    {
        try {
            $proposals = session('user_proposals', []);
            $updatedProposals = collect($proposals)->reject(function ($proposal) use ($proposalId) {
                return $proposal['id'] === $proposalId && $proposal['user_id'] === Auth::id();
            })->values()->toArray();

            session(['user_proposals' => $updatedProposals]);

            return response()->json([
                'success' => true,
                'message' => 'Proposal berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus proposal'
            ], 500);
        }
    }

    /**
     * Get business field options
     */
    public function getBusinessFields()
    {
        $businessFields = [
            'Technology' => 'Teknologi Informasi',
            'Finance' => 'Keuangan & Perbankan',
            'Manufacturing' => 'Manufaktur',
            'Healthcare' => 'Kesehatan',
            'Education' => 'Pendidikan',
            'Retail' => 'Retail & E-commerce',
            'Energy' => 'Energi & Pertambangan',
            'Transportation' => 'Transportasi & Logistik',
            'Construction' => 'Konstruksi & Properti',
            'Media' => 'Media & Komunikasi',
            'Government' => 'Pemerintahan',
            'Other' => 'Lainnya'
        ];

        return response()->json($businessFields);
    }

    /**
     * Show signature page
     */
    public function showSignaturePage()
    {
        $user = Auth::user();
        $activeSignature = $user->activeSignature;
        $allSignatures = $user->signatures()->latest()->get();
        
        return view('mahasiswa.signature', [
            'activeSignature' => $activeSignature,
            'allSignatures' => $allSignatures
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
                'notes' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $signatureData = $request->signature_data;
            
            // Validate base64 image
            if (!preg_match('/^data:image\/(png|jpeg|jpg);base64,/', $signatureData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format signature tidak valid'
                ], 422);
            }

            // Extract base64 data
            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $signatureData);
            $imageData = base64_decode($imageData);
            
            if ($imageData === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses data signature'
                ], 422);
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
                'notes' => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Signature berhasil disimpan',
                'signature' => [
                    'id' => $signature->id,
                    'url' => $signature->signature_url,
                    'created_at' => $signature->created_at->format('d M Y H:i'),
                    'file_size' => $signature->formatted_file_size
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error saving signature', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan signature'
            ], 500);
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
                    'created_at' => $signature->created_at->format('d M Y H:i')
                ];
            });

            return response()->json([
                'success' => true,
                'signatures' => $formattedSignatures,
                'total' => $signatures->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data signature'
            ], 500);
        }
    }

    /**
     * Delete signature
     */
    public function deleteSignature($signatureId)
    {
        try {
            $signature = UserSignature::where('id', $signatureId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$signature) {
                return response()->json([
                    'success' => false,
                    'message' => 'Signature tidak ditemukan'
                ], 404);
            }

            // Delete file from storage
            if ($signature->signature_path && Storage::disk('public')->exists($signature->signature_path)) {
                Storage::disk('public')->delete($signature->signature_path);
            }

            // Delete record
            $signature->delete();

            return response()->json([
                'success' => true,
                'message' => 'Signature berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus signature'
            ], 500);
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
            $signature = UserSignature::where('id', $signatureId)
                ->where('user_id', $user->id)
                ->first();

            if (!$signature) {
                return response()->json([
                    'success' => false,
                    'message' => 'Signature tidak ditemukan'
                ], 404);
            }

            // Deactivate all signatures
            UserSignature::where('user_id', $user->id)->update(['is_active' => false]);
            
            // Activate selected signature
            $signature->update(['is_active' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Signature aktif berhasil diubah'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah signature aktif'
            ], 500);
        }
    }

    /**
     * Download signature file
     */
    public function downloadSignature($signatureId)
    {
        try {
            $signature = UserSignature::where('id', $signatureId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$signature) {
                abort(404, 'Signature tidak ditemukan');
            }

            if (!$signature->signature_path || !Storage::disk('public')->exists($signature->signature_path)) {
                abort(404, 'File signature tidak ditemukan');
            }

            return Storage::disk('public')->download(
                $signature->signature_path,
                'signature_' . Auth::user()->name . '_' . $signature->id . '.png'
            );

        } catch (\Exception $e) {
            \Log::error('Error downloading signature', [
                'signature_id' => $signatureId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Gagal mengunduh signature');
        }
    }
}