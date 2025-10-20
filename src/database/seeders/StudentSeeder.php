<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
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
                    'name' => 'Ahmad Rahman Mahasiswa',
                    'username' => 'ahmad.rahman',
                    'email' => 'ahmad.rahman@student.its.ac.id',
                    'password' => Hash::make('password123'),
                    'role' => 'mahasiswa'
                ],
                'student_data' => [
                    'nrp' => '5025211001',
                    'nama_resmi' => 'Ahmad Rahman Mahasiswa',
                    'email_kampus' => 'ahmad.rahman@student.its.ac.id',
                    'prodi' => 'Teknik Informatika',
                    'fakultas' => 'Fakultas Teknologi Informasi dan Komunikasi',
                    'angkatan' => '2025',
                    'semester_berjalan' => 1,
                    'sks_total' => 20,
                    'status_akademik' => 'aktif'
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
                ]
            ]
        ];

        foreach ($studentsData as $data) {
            // Create user first
            $user = User::create($data['user_data']);
            
            // Then create student profile
            $studentData = $data['student_data'];
            $studentData['user_id'] = $user->id;
            
            Student::create($studentData);
            
            $this->command->info("Created student: {$studentData['nama_resmi']} ({$studentData['nrp']})");
        }
    }
}