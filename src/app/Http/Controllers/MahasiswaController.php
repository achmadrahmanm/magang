<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\UserSignature;
use App\Models\BusinessField;
use App\Models\Application;
use App\Models\ApplicationMember;
use App\Models\ApplicationDocument;
use App\Models\Student;

class MahasiswaController extends Controller
{
    /**
     * Display the formal request form
     */
    public function showFormalRequestForm()
    {
        $draft = $this->getUserDraft();
        $businessFields = $this->getBusinessFieldsForForm();

        return view('mahasiswa.form_formalrequests', [
            'draft' => $draft,
            'businessFields' => $businessFields
        ]);
    }

    /**
     * Get user's draft data
     */
    public function getUserDraft()
    {
        try {
            $user = Auth::user();

            // Get all drafts for the current user
            $drafts = Application::with(['members.student', 'documents'])
                ->where('submitted_by', $user->id)
                ->where('status', 'draft')
                ->latest()
                ->get();

            if ($drafts->isEmpty()) {
                return null;
            }

            // Prioritize draft with documents, otherwise use the most recent
            $draft = $drafts->first(function ($d) {
                return $d->documents->where('document_type', 'draft_purpose_letter')->isNotEmpty();
            }) ?: $drafts->first();

            // Format draft data for form population
            $formattedDraft = [
                'id' => $draft->id,
                'topic' => $draft->notes,
                'company' => $draft->institution_name,
                'company_address' => $draft->institution_address,
                'business_field' => $draft->business_field,
                'department' => $draft->placement_division,
                'division' => $draft->division ?: '',
                'start_date' => $draft->planned_start_date ? $draft->planned_start_date->format('Y-m-d') : '',
                'duration' => $draft->planned_start_date && $draft->planned_end_date
                    ? $draft->planned_start_date->diffInMonths($draft->planned_end_date)
                    : '',
                'members' => [],
                'has_proposal_file' => false,
                'proposal_file_name' => '',
                'saved_at' => $draft->updated_at->format('d M Y H:i')
            ];

            // Get members data
            foreach ($draft->members as $member) {
                $student = $member->student;
                if ($student) {
                    $formattedDraft['members'][] = [
                        'student_id' => $student->nrp,
                        'name' => $student->nama_resmi,
                        'email' => $student->email_kampus,
                        'year' => $student->angkatan,
                        'role' => $member->role
                    ];
                }
            }

            // Check for proposal file
            $proposalDoc = $draft->documents
                ->where('document_type', 'draft_purpose_letter')
                ->first();

            if ($proposalDoc) {
                $formattedDraft['has_proposal_file'] = true;
                $formattedDraft['proposal_file_name'] = $proposalDoc->document_name;
                $formattedDraft['proposal_file_url'] = url('storage/' . $proposalDoc->file_path);
            }

            return $formattedDraft;
        } catch (\Exception $e) {
            \Log::error('Error getting user draft', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Load draft data via AJAX
     */
    public function loadDraft()
    {
        try {
            $draft = $this->getUserDraft();

            return response()->json([
                'success' => true,
                'draft' => $draft,
                'has_draft' => !is_null($draft)
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading draft via AJAX', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat draft',
                'draft' => null,
                'has_draft' => false
            ], 500);
        }
    }

    /**
     * Get business fields for form dropdown
     */
    private function getBusinessFieldsForForm()
    {
        try {
            $businessFields = BusinessField::active()->ordered()->get();

            return $businessFields->map(function ($field) {
                return [
                    'code' => $field->code,
                    'name' => $field->name,
                    'name_en' => $field->name_en
                ];
            });
        } catch (\Exception $e) {
            // Return fallback options if database fails
            return collect([
                ['code' => 'technology', 'name' => 'Teknologi Informasi', 'name_en' => 'Technology'],
                ['code' => 'finance', 'name' => 'Keuangan & Perbankan', 'name_en' => 'Finance'],
                ['code' => 'manufacturing', 'name' => 'Manufaktur', 'name_en' => 'Manufacturing'],
                ['code' => 'healthcare', 'name' => 'Kesehatan', 'name_en' => 'Healthcare'],
                ['code' => 'education', 'name' => 'Pendidikan', 'name_en' => 'Education'],
                ['code' => 'retail', 'name' => 'Retail & E-commerce', 'name_en' => 'Retail'],
                ['code' => 'energy', 'name' => 'Energi & Pertambangan', 'name_en' => 'Energy'],
                ['code' => 'transportation', 'name' => 'Transportasi & Logistik', 'name_en' => 'Transportation'],
                ['code' => 'construction', 'name' => 'Konstruksi & Properti', 'name_en' => 'Construction'],
                ['code' => 'media', 'name' => 'Media & Komunikasi', 'name_en' => 'Media'],
                ['code' => 'government', 'name' => 'Pemerintahan', 'name_en' => 'Government'],
                ['code' => 'other', 'name' => 'Lainnya', 'name_en' => 'Other']
            ]);
        }
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

            // Get current user's student record
            $currentStudent = Student::where('user_id', Auth::id())->first();
            if (!$currentStudent) {
                return back()
                    ->withInput()
                    ->with('error', 'Data mahasiswa tidak ditemukan. Silakan hubungi administrator.');
            }

            DB::beginTransaction();

            // Calculate end date based on duration
            $startDate = \Carbon\Carbon::parse($request->start_date);
            $endDate = $startDate->copy()->addMonths($request->duration);

            // Create application
            $application = Application::create([
                'institution_name' => $request->company,
                'institution_address' => $request->company_address,
                'business_field' => $request->business_field,
                'placement_division' => $request->department,
                'division' => $request->division,
                'planned_start_date' => $request->start_date,
                'planned_end_date' => $endDate,
                'notes' => $request->topic,
                'status' => 'submitted',
                'submitted_by' => Auth::id(),
            ]);

            // Handle file upload
            if ($request->hasFile('proposal_file')) {
                $file = $request->file('proposal_file');
                $filename = 'proposal_' . $application->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('applications/' . $application->id, $filename, 'public');

                // Create document record
                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'document_type' => 'purpose_letter',
                    'document_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'description' => 'Surat permohonan magang yang diupload saat aplikasi',
                    'is_required' => true,
                    'uploaded_by' => Auth::id(),
                ]);
            }

            // Add current user as leader by default
            ApplicationMember::create([
                'application_id' => $application->id,
                'student_id' => $currentStudent->id,
                'role' => 'leader',
                'notes' => 'Pengaju utama aplikasi magang',
                'joined_at' => now(),
            ]);

            // Add other members
            foreach ($request->members as $memberData) {
                // Skip if it's the current user (already added as leader)
                if ($memberData['student_id'] === $currentStudent->nrp) {
                    continue;
                }

                // Find or create student by NRP
                $student = Student::where('nrp', $memberData['student_id'])->first();

                if (!$student) {
                    // Create temporary student record if not exists
                    // In production, you might want to validate this differently
                    $student = Student::create([
                        'user_id' => null, // Will be linked when user registers
                        'nrp' => $memberData['student_id'],
                        'nama_resmi' => $memberData['name'],
                        'email_kampus' => $memberData['email'],
                        'prodi' => $currentStudent->prodi, // Use same program as leader
                        'fakultas' => $currentStudent->fakultas,
                        'angkatan' => $memberData['year'],
                        'semester_berjalan' => 1,
                        'sks_total' => 0,
                        'status_akademik' => 'aktif'
                    ]);
                }

                ApplicationMember::create([
                    'application_id' => $application->id,
                    'student_id' => $student->id,
                    'role' => 'member',
                    'notes' => 'Anggota tim magang',
                    'joined_at' => now(),
                ]);
            }

            DB::commit();

            // Log the submission
            \Log::info('Internship Application Submitted', [
                'application_id' => $application->id,
                'user_id' => Auth::id(),
                'company' => $request->company,
                'members_count' => count($request->members),
                'file_size' => $request->hasFile('proposal_file') ? $request->file('proposal_file')->getSize() : 0
            ]);

            return redirect()
                ->route('mahasiswa.formal-requests')
                ->with('success', "Aplikasi magang berhasil disubmit! ID Aplikasi: APP-{$application->id}")
                ->with('application_id', $application->id);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error submitting application', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan aplikasi. Silakan coba lagi.');
        }
    }

    /**
     * Save proposal as draft
     */
    public function saveDraft(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get current user's student record
            $currentStudent = Student::where('user_id', Auth::id())->first();
            if (!$currentStudent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data mahasiswa tidak ditemukan'
                ], 422);
            }

            // Check if user already has drafts (prioritize one with documents)
            $allDrafts = Application::with('documents')
                ->where('submitted_by', Auth::id())
                ->where('status', 'draft')
                ->latest()
                ->get();

            $existingDraft = $allDrafts->first(function ($d) {
                return $d->documents->where('document_type', 'draft_purpose_letter')->isNotEmpty();
            }) ?: $allDrafts->first();

            $endDate = null;
            if ($request->start_date && $request->duration) {
                $startDate = \Carbon\Carbon::parse($request->start_date);
                $endDate = $startDate->copy()->addMonths(intval($request->duration));
            }

            if ($existingDraft) {
                // Update existing draft
                $existingDraft->update([
                    'institution_name' => $request->company ?: $existingDraft->institution_name,
                    'institution_address' => $request->company_address ?: $existingDraft->institution_address,
                    'business_field' => $request->business_field ?: $existingDraft->business_field,
                    'placement_division' => $request->department ?: $existingDraft->placement_division,
                    'division' => $request->division ?: $existingDraft->division,
                    'planned_start_date' => $request->start_date ?: $existingDraft->planned_start_date,
                    'planned_end_date' => $endDate ?: $existingDraft->planned_end_date,
                    'notes' => $request->topic ?: $existingDraft->notes,
                ]);

                $application = $existingDraft;
            } else {
                // Create new draft
                $application = Application::create([
                    'institution_name' => $request->company ?: 'Draft Company',
                    'institution_address' => $request->company_address ?: '',
                    'business_field' => $request->business_field ?: 'other',
                    'placement_division' => $request->department ?: 'Draft Department',
                    'division' => $request->division ?: '',
                    'planned_start_date' => $request->start_date ?: now()->addMonth(),
                    'planned_end_date' => $endDate ?: now()->addMonths(6),
                    'notes' => $request->topic ?: 'Draft proposal',
                    'status' => 'draft',
                    'submitted_by' => Auth::id(),
                ]);                // Add current user as leader
                ApplicationMember::create([
                    'application_id' => $application->id,
                    'student_id' => $currentStudent->id,
                    'role' => 'leader',
                    'notes' => 'Draft - Pengaju utama',
                    'joined_at' => now(),
                ]);
            }

            // Handle file upload for draft if exists
            if ($request->hasFile('proposal_file')) {
                // Delete old draft file if exists  
                $oldDocument = ApplicationDocument::where('application_id', $application->id)
                    ->where('document_type', 'draft_purpose_letter')
                    ->first();

                if ($oldDocument) {
                    if (Storage::disk('public')->exists($oldDocument->file_path)) {
                        Storage::disk('public')->delete($oldDocument->file_path);
                    }
                    $oldDocument->delete();
                }

                // Upload new file
                $file = $request->file('proposal_file');
                $filename = 'draft_' . $application->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('applications/' . $application->id . '/drafts', $filename, 'public');

                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'document_type' => 'draft_purpose_letter',
                    'document_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'description' => 'Draft proposal document',
                    'is_required' => false,
                    'uploaded_by' => Auth::id(),
                ]);
            }

            // Clean up duplicate drafts (keep only the current one)
            if ($allDrafts->count() > 1) {
                $draftsToDelete = $allDrafts->where('id', '!=', $application->id);
                foreach ($draftsToDelete as $draftToDelete) {
                    // Delete documents of duplicate drafts
                    foreach ($draftToDelete->documents as $doc) {
                        if (Storage::disk('public')->exists($doc->file_path)) {
                            Storage::disk('public')->delete($doc->file_path);
                        }
                        $doc->delete();
                    }
                    // Delete members of duplicate drafts
                    $draftToDelete->members()->delete();
                    // Delete the draft application
                    $draftToDelete->delete();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Draft berhasil disimpan',
                'draft_id' => $application->id,
                'application_id' => 'DRAFT-' . $application->id,
                'saved_at' => $application->updated_at->format('d M Y H:i')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error saving draft', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

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
        try {
            $user = Auth::user();

            // Get applications where user is the submitter or a member
            $applications = Application::with([
                'members.student.user',
                'documents',
                'submittedBy',
                'reviewedBy'
            ])
                ->where('submitted_by', $user->id)
                ->latest()
                ->get();

            // Format applications data
            $formattedApplications = $applications->map(function ($application) {
                $members = $application->members->map(function ($member) {
                    return [
                        'student_id' => $member->student->nrp ?? 'N/A',
                        'name' => $member->student->nama_resmi ?? 'Unknown',
                        'email' => $member->student->email_kampus ?? 'N/A',
                        'year' => $member->student->angkatan ?? date('Y'),
                        'role' => $member->role,
                        'notes' => $member->notes
                    ];
                });

                $documents = $application->documents->map(function ($doc) {
                    return [
                        'id' => $doc->id,
                        'type' => $doc->document_type,
                        'name' => $doc->document_name,
                        'size' => $doc->file_size_human,
                        'is_verified' => $doc->is_verified,
                        'uploaded_at' => $doc->created_at->format('d M Y H:i')
                    ];
                });

                return [
                    'id' => $application->id,
                    'application_id' => 'APP-' . $application->id,
                    'user_id' => $application->submitted_by,
                    'user_name' => $application->submittedBy->name,
                    'user_email' => $application->submittedBy->email,
                    'topic' => $application->notes,
                    'company' => $application->institution_name,
                    'company_address' => $application->institution_address,
                    'business_field' => $application->business_field,
                    'department' => $application->placement_division,
                    'division' => $application->division,
                    'start_date' => $application->planned_start_date->format('Y-m-d'),
                    'end_date' => $application->planned_end_date->format('Y-m-d'),
                    'duration' => $application->getDurationInDays(),
                    'members' => $members,
                    'documents' => $documents,
                    'status' => $application->status,
                    'status_display' => $application->getStatusDisplayText(),
                    'status_badge_class' => $application->getStatusBadgeClass(),
                    'status_note' => $application->status_note,
                    'rejection_reason' => $application->rejection_reason,
                    'reviewed_by' => $application->reviewedBy?->name,
                    'reviewed_at' => $application->reviewed_at?->format('d M Y H:i'),
                    'submitted_at' => $application->created_at->format('d M Y H:i'),
                    'created_at' => $application->created_at,
                    'updated_at' => $application->updated_at
                ];
            });

            // Get draft data (still from session for now)
            $draft = session('proposal_draft');

            return response()->json([
                'success' => true,
                'applications' => $formattedApplications,
                'proposals' => $formattedApplications, // For backward compatibility
                'draft' => $draft,
                'total' => $formattedApplications->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching applications', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data aplikasi',
                'applications' => [],
                'proposals' => [],
                'total' => 0
            ], 500);
        }
    }

    /**
     * Download proposal file
     */
    public function downloadProposal($applicationId)
    {
        try {
            // Find application
            $application = Application::with(['documents', 'submittedBy'])
                ->where('id', $applicationId)
                ->first();

            if (!$application) {
                abort(404, 'Aplikasi tidak ditemukan');
            }

            // Check if user owns this application or is a member
            $userCanAccess = $application->submitted_by === Auth::id() ||
                $application->members()->whereHas('student', function ($q) {
                    $q->where('user_id', Auth::id());
                })->exists();

            if (!$userCanAccess) {
                abort(403, 'Anda tidak memiliki akses ke aplikasi ini');
            }

            // Get the main proposal document (purpose_letter)
            $document = $application->documents()
                ->where('document_type', 'purpose_letter')
                ->first();

            if (!$document) {
                abort(404, 'Dokumen proposal tidak ditemukan');
            }

            if (!Storage::disk('public')->exists($document->file_path)) {
                abort(404, 'File tidak ditemukan di storage');
            }

            return Storage::disk('public')->download(
                $document->file_path,
                'Proposal_' . Str::slug($application->institution_name) . '_APP-' . $application->id . '.pdf'
            );
        } catch (\Exception $e) {
            \Log::error('Error downloading application document', [
                'application_id' => $applicationId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Gagal mengunduh file dokumen');
        }
    }

    /**
     * Preview proposal file
     */
    public function previewProposal($applicationId)
    {
        try {
            // Find application
            $application = Application::with('documents')
                ->where('id', $applicationId)
                ->first();

            if (!$application) {
                abort(404, 'Aplikasi tidak ditemukan');
            }

            // Check if user owns this application or is a member
            $userCanAccess = $application->submitted_by === Auth::id() ||
                $application->members()->whereHas('student', function ($q) {
                    $q->where('user_id', Auth::id());
                })->exists();

            if (!$userCanAccess) {
                abort(403, 'Anda tidak memiliki akses ke aplikasi ini');
            }

            // Get the main proposal document (purpose_letter)
            $document = $application->documents()
                ->where('document_type', 'purpose_letter')
                ->first();

            if (!$document) {
                abort(404, 'Dokumen proposal tidak ditemukan');
            }

            if (!Storage::disk('public')->exists($document->file_path)) {
                abort(404, 'File tidak ditemukan di storage');
            }

            $filePath = Storage::disk('public')->path($document->file_path);

            return response()->file($filePath, [
                'Content-Type' => $document->mime_type ?: 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $document->document_name . '"'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error previewing application document', [
                'application_id' => $applicationId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            abort(404, 'File tidak dapat ditampilkan');
        }
    }

    /**
     * Delete proposal/application
     */
    public function deleteProposal($applicationId)
    {
        try {
            DB::beginTransaction();

            // Find application
            $application = Application::where('id', $applicationId)
                ->where('submitted_by', Auth::id())
                ->first();

            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aplikasi tidak ditemukan atau Anda tidak memiliki akses'
                ], 404);
            }

            // Check if application can be deleted (only submitted or rejected status)
            if (!in_array($application->status, ['submitted', 'rejected'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aplikasi dengan status "' . $application->getStatusDisplayText() . '" tidak dapat dihapus'
                ], 422);
            }

            // Delete all associated documents from storage
            $documents = $application->documents;
            foreach ($documents as $document) {
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
            }

            // Delete the application (cascade will handle members and documents)
            $companyName = $application->institution_name;
            $application->delete();

            DB::commit();

            \Log::info('Application deleted', [
                'application_id' => $applicationId,
                'user_id' => Auth::id(),
                'company' => $companyName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error deleting application', [
                'application_id' => $applicationId,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus aplikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get business field options
     */
    public function getBusinessFields()
    {
        try {
            // Get active business fields from database
            $businessFields = BusinessField::active()
                ->ordered()
                ->get()
                ->map(function ($field) {
                    return [
                        'code' => $field->code,
                        'name' => $field->name,
                        'name_en' => $field->name_en,
                        'description' => $field->description,
                        'icon' => $field->display_icon,
                        'color' => $field->display_color,
                        'metadata' => $field->metadata
                    ];
                });

            // For backward compatibility, also return simple key-value pairs
            $simpleFields = BusinessField::getSelectOptions();

            return response()->json([
                'success' => true,
                'data' => $businessFields,
                'simple' => $simpleFields, // For simple select dropdowns
                'total' => $businessFields->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching business fields', [
                'error' => $e->getMessage()
            ]);

            // Fallback to hardcoded data if database fails
            $fallbackFields = [
                'technology' => 'Teknologi Informasi',
                'finance' => 'Keuangan & Perbankan',
                'manufacturing' => 'Manufaktur',
                'healthcare' => 'Kesehatan',
                'education' => 'Pendidikan',
                'retail' => 'Retail & E-commerce',
                'energy' => 'Energi & Pertambangan',
                'transportation' => 'Transportasi & Logistik',
                'construction' => 'Konstruksi & Properti',
                'media' => 'Media & Komunikasi',
                'government' => 'Pemerintahan',
                'other' => 'Lainnya'
            ];

            return response()->json([
                'success' => false,
                'message' => 'Using fallback data',
                'data' => collect($fallbackFields)->map(function ($name, $code) {
                    return [
                        'code' => $code,
                        'name' => $name,
                        'icon' => 'fas fa-building',
                        'color' => '#6c757d'
                    ];
                })->values(),
                'simple' => $fallbackFields
            ]);
        }
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
