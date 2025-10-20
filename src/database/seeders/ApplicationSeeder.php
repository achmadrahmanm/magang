<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\ApplicationMember;
use App\Models\ApplicationDocument;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some students for creating applications
        $students = Student::with('user')->get();
        
        if ($students->count() < 3) {
            $this->command->error('Need at least 3 students to create sample applications. Run StudentSeeder first.');
            return;
        }

        // Create sample applications
        $applicationsData = [
            [
                'institution_name' => 'PT Telkom Indonesia',
                'institution_address' => 'Jl. Japati No. 1, Bandung, Jawa Barat 40133',
                'business_field' => 'Teknologi Informasi dan Komunikasi',
                'placement_division' => 'Software Development',
                'planned_start_date' => '2025-02-01',
                'planned_end_date' => '2025-07-31',
                'notes' => 'Program magang untuk pengembangan aplikasi mobile dan web.',
                'status' => 'submitted',
                'members' => [
                    ['student_index' => 0, 'role' => 'leader'],
                    ['student_index' => 1, 'role' => 'member'],
                ]
            ],
            [
                'institution_name' => 'PT Bank Central Asia Tbk',
                'institution_address' => 'Menara BCA, Jl. M.H. Thamrin No. 1, Jakarta Pusat 10310',
                'business_field' => 'Perbankan dan Keuangan',
                'placement_division' => 'IT Security',
                'planned_start_date' => '2025-03-01',
                'planned_end_date' => '2025-08-31',
                'notes' => 'Program magang fokus pada keamanan sistem perbankan.',
                'status' => 'reviewing',
                'members' => [
                    ['student_index' => 2, 'role' => 'leader'],
                ]
            ],
            [
                'institution_name' => 'PT Gojek Indonesia',
                'institution_address' => 'Pasaraya Blok M, Jl. Iskandarsyah II No. 2, Jakarta Selatan',
                'business_field' => 'Teknologi Transportation & Logistics',
                'placement_division' => 'Backend Engineering',
                'planned_start_date' => '2025-01-15',
                'planned_end_date' => '2025-06-15',
                'notes' => 'Program magang untuk pengembangan microservices dan API.',
                'status' => 'approved',
                'members' => [
                    ['student_index' => 3, 'role' => 'leader'],
                    ['student_index' => 4, 'role' => 'member'],
                ]
            ],
            [
                'institution_name' => 'PT Shopee International Indonesia',
                'institution_address' => 'Wisma 77 Tower 2, Jl. S. Parman Kav. 77, Jakarta Barat',
                'business_field' => 'E-commerce',
                'placement_division' => 'Data Science',
                'planned_start_date' => '2025-02-15',
                'planned_end_date' => '2025-07-15',
                'notes' => 'Program magang untuk analisis data dan machine learning.',
                'status' => 'rejected',
                'rejection_reason' => 'Kuota untuk divisi Data Science sudah penuh.',
                'members' => [
                    ['student_index' => 5, 'role' => 'leader'],
                ]
            ]
        ];

        foreach ($applicationsData as $index => $appData) {
            // Create application
            $application = Application::create([
                'institution_name' => $appData['institution_name'],
                'institution_address' => $appData['institution_address'],
                'business_field' => $appData['business_field'],
                'placement_division' => $appData['placement_division'],
                'planned_start_date' => $appData['planned_start_date'],
                'planned_end_date' => $appData['planned_end_date'],
                'notes' => $appData['notes'],
                'status' => $appData['status'],
                'rejection_reason' => $appData['rejection_reason'] ?? null,
                'submitted_by' => $students[$appData['members'][0]['student_index']]->user_id,
                'reviewed_by' => $appData['status'] !== 'submitted' ? 1 : null, // Assuming user id 1 is admin
                'reviewed_at' => $appData['status'] !== 'submitted' ? now()->subDays(rand(1, 7)) : null,
            ]);

            // Add members to application
            foreach ($appData['members'] as $memberData) {
                ApplicationMember::create([
                    'application_id' => $application->id,
                    'student_id' => $students[$memberData['student_index']]->id,
                    'role' => $memberData['role'],
                    'notes' => $memberData['role'] === 'leader' ? 'Ketua kelompok magang' : 'Anggota kelompok magang',
                    'joined_at' => now()->subDays(rand(1, 30)),
                ]);
            }

            // Create sample documents for each application
            $documentTypes = ['purpose_letter', 'cv', 'transcript'];
            foreach ($documentTypes as $docIndex => $docType) {
                ApplicationDocument::create([
                    'application_id' => $application->id,
                    'document_type' => $docType,
                    'document_name' => $this->getDocumentName($docType, $index),
                    'file_path' => 'applications/' . $application->id . '/' . $docType . '_' . time() . '.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => rand(100000, 2000000), // 100KB to 2MB
                    'description' => $this->getDocumentDescription($docType),
                    'is_required' => in_array($docType, ['purpose_letter', 'cv']),
                    'is_verified' => $application->status === 'approved' ? true : rand(0, 1),
                    'verified_by' => $application->status === 'approved' ? 1 : ($docIndex % 2 === 0 ? 1 : null),
                    'verified_at' => $application->status === 'approved' ? now()->subDays(rand(1, 5)) : ($docIndex % 2 === 0 ? now()->subDays(rand(1, 10)) : null),
                    'uploaded_by' => $students[$appData['members'][0]['student_index']]->user_id,
                ]);
            }

            $this->command->info("Created application for {$appData['institution_name']} with {$application->members()->count()} members and {$application->documents()->count()} documents");
        }

        $this->command->info("Created " . Application::count() . " applications total");
    }

    /**
     * Get document name based on type
     */
    private function getDocumentName(string $type, int $index): string
    {
        return match($type) {
            'purpose_letter' => "Surat_Permohonan_Magang_{$index}.pdf",
            'cv' => "CV_Mahasiswa_{$index}.pdf",
            'transcript' => "Transkrip_Nilai_{$index}.pdf",
            default => "Document_{$type}_{$index}.pdf"
        };
    }

    /**
     * Get document description based on type
     */
    private function getDocumentDescription(string $type): string
    {
        return match($type) {
            'purpose_letter' => 'Surat permohonan magang resmi dari kampus',
            'cv' => 'Curriculum Vitae mahasiswa yang berisi riwayat pendidikan dan pengalaman',
            'transcript' => 'Transkrip nilai akademik terbaru',
            default => 'Dokumen pendukung aplikasi magang'
        };
    }
}