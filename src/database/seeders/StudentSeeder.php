<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\UserIdentity;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample students data
        $studentsData = [
            [
                'user_data' => [
                    'name' => 'Ahmad Rahman',
                    'username' => 'ahmad.rahman',
                    'email' => 'ahmad.rahman@student.its.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa'
                ],
                'student_data' => [
                    'nrp' => '5025211001',
                    'nama_resmi' => 'Ahmad Rahman',
                    'email_kampus' => 'ahmad.rahman@student.its.ac.id',
                    'prodi' => 'Teknik Informatika',
                    'fakultas' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'angkatan' => '2025',
                    'semester_berjalan' => 1,
                    'sks_total' => 20,
                    'status_akademik' => 'aktif'
                ],
                'identity_data' => [
                    'email' => 'ahmad.rahman@student.its.ac.id',
                    'campus_id' => 'ITS01',
                    'department' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'major' => 'Teknik Informatika',
                    'name' => 'Ahmad Rahman',
                    'gender' => 'male',
                    'dob' => '2002-05-15',
                    'phone' => '+62-812-1111-0001',
                    'join_date' => '2025-08-01',
                    'sks_score' => 20
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Siti Nurhaliza',
                    'username' => 'siti.nurhaliza',
                    'email' => 'siti.nurhaliza@student.its.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa'
                ],
                'student_data' => [
                    'nrp' => '5025211002',
                    'nama_resmi' => 'Siti Nurhaliza',
                    'email_kampus' => 'siti.nurhaliza@student.its.ac.id',
                    'prodi' => 'Sistem Informasi',
                    'fakultas' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'angkatan' => '2025',
                    'semester_berjalan' => 1,
                    'sks_total' => 18,
                    'status_akademik' => 'aktif'
                ],
                'identity_data' => [
                    'email' => 'siti.nurhaliza@student.its.ac.id',
                    'campus_id' => 'ITS01',
                    'department' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'major' => 'Sistem Informasi',
                    'name' => 'Siti Nurhaliza',
                    'gender' => 'female',
                    'dob' => '2002-08-22',
                    'phone' => '+62-813-2222-0002',
                    'join_date' => '2025-08-01',
                    'sks_score' => 18
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Budi Santoso',
                    'username' => 'budi.santoso',
                    'email' => 'budi.santoso@student.its.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa'
                ],
                'student_data' => [
                    'nrp' => '5023211003',
                    'nama_resmi' => 'Budi Santoso',
                    'email_kampus' => 'budi.santoso@student.its.ac.id',
                    'prodi' => 'Teknik Informatika',
                    'fakultas' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'angkatan' => '2023',
                    'semester_berjalan' => 5,
                    'sks_total' => 95,
                    'status_akademik' => 'aktif'
                ],
                'identity_data' => [
                    'email' => 'budi.santoso@student.its.ac.id',
                    'campus_id' => 'ITS01',
                    'department' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'major' => 'Teknik Informatika',
                    'name' => 'Budi Santoso',
                    'gender' => 'male',
                    'dob' => '2000-12-10',
                    'phone' => '+62-814-3333-0003',
                    'join_date' => '2023-08-01',
                    'sks_score' => 95
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Dewi Kartika',
                    'username' => 'dewi.kartika',
                    'email' => 'dewi.kartika@student.its.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa'
                ],
                'student_data' => [
                    'nrp' => '5022211004',
                    'nama_resmi' => 'Dewi Kartika Sari',
                    'email_kampus' => 'dewi.kartika@student.its.ac.id',
                    'prodi' => 'Teknik Komputer',
                    'fakultas' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'angkatan' => '2022',
                    'semester_berjalan' => 7,
                    'sks_total' => 130,
                    'status_akademik' => 'aktif'
                ],
                'identity_data' => [
                    'email' => 'dewi.kartika@student.its.ac.id',
                    'campus_id' => 'ITS01',
                    'department' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'major' => 'Teknik Komputer',
                    'name' => 'Dewi Kartika Sari',
                    'gender' => 'female',
                    'dob' => '1999-06-18',
                    'phone' => '+62-815-4444-0004',
                    'join_date' => '2022-08-01',
                    'sks_score' => 130
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Eko Prasetyo',
                    'username' => 'eko.prasetyo',
                    'email' => 'eko.prasetyo@student.its.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa'
                ],
                'student_data' => [
                    'nrp' => '5021211005',
                    'nama_resmi' => 'Eko Prasetyo Wibowo',
                    'email_kampus' => 'eko.prasetyo@student.its.ac.id',
                    'prodi' => 'Teknologi Informasi',
                    'fakultas' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'angkatan' => '2021',
                    'semester_berjalan' => 8,
                    'sks_total' => 144,
                    'status_akademik' => 'lulus'
                ],
                'identity_data' => [
                    'email' => 'eko.prasetyo@student.its.ac.id',
                    'campus_id' => 'ITS01',
                    'department' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'major' => 'Teknologi Informasi',
                    'name' => 'Eko Prasetyo Wibowo',
                    'gender' => 'male',
                    'dob' => '1998-11-30',
                    'phone' => '+62-816-5555-0005',
                    'join_date' => '2021-08-01',
                    'sks_score' => 144
                ]
            ],
            [
                'user_data' => [
                    'name' => 'Fitri Handayani',
                    'username' => 'fitri.handayani',
                    'email' => 'fitri.handayani@student.its.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa'
                ],
                'student_data' => [
                    'nrp' => '5024211006',
                    'nama_resmi' => 'Fitri Handayani',
                    'email_kampus' => 'fitri.handayani@student.its.ac.id',
                    'prodi' => 'Sistem Informasi',
                    'fakultas' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'angkatan' => '2024',
                    'semester_berjalan' => 3,
                    'sks_total' => 54,
                    'status_akademik' => 'cuti'
                ],
                'identity_data' => [
                    'email' => 'fitri.handayani@student.its.ac.id',
                    'campus_id' => 'ITS01',
                    'department' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'major' => 'Sistem Informasi',
                    'name' => 'Fitri Handayani',
                    'gender' => 'female',
                    'dob' => '2001-03-25',
                    'phone' => '+62-817-6666-0006',
                    'join_date' => '2024-08-01',
                    'sks_score' => 54
                ]
            ]
        ];

        foreach ($studentsData as $data) {
            // Create user first
            $user = User::create($data['user_data']);

            // Then create student profile
            $studentData = $data['student_data'];
            $studentData['user_id'] = $user->id;

            $student = Student::create($studentData);

            // Create user identity with NRP as user_id
            $identityData = $data['identity_data'];
            $identityData['user_id'] = $studentData['nrp']; // Use NRP as user_id in user_identities

            UserIdentity::create($identityData);

            $this->command->info("Created student: {$studentData['nama_resmi']} ({$studentData['nrp']}) with identity");
        }
    }
}
