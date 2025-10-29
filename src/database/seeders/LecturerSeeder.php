<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\User;
use App\Models\UserIdentity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturers = [
            [
                'name' => 'Dr. John Doe',
                'username' => 'johndoe',
                'email' => 'john.doe@university.edu',
                'nip' => '1234567890',
                'department' => 'Computer Science',
                'major' => 'Informatics',
                'gender' => 'male',
                'phone' => '081234567890',
                'prodi' => 'Informatics',
                'fakultas' => 'Computer Science',
                'jabatan' => 'Dosen',
            ],
            [
                'name' => 'Prof. Jane Smith',
                'username' => 'janesmith',
                'email' => 'jane.smith@university.edu',
                'nip' => '1234567891',
                'department' => 'Electrical Engineering',
                'major' => 'Electrical Engineering',
                'gender' => 'female',
                'phone' => '081234567891',
                'prodi' => 'Electrical Engineering',
                'fakultas' => 'Engineering',
                'jabatan' => 'Professor',
            ],
            [
                'name' => 'Dr. Michael Johnson',
                'username' => 'michaeljohnson',
                'email' => 'michael.johnson@university.edu',
                'nip' => '1234567892',
                'department' => 'Mechanical Engineering',
                'major' => 'Mechanical Engineering',
                'gender' => 'male',
                'phone' => '081234567892',
                'prodi' => 'Mechanical Engineering',
                'fakultas' => 'Engineering',
                'jabatan' => 'Dosen',
            ],
            [
                'name' => 'Dr. Emily Davis',
                'username' => 'emilydavis',
                'email' => 'emily.davis@university.edu',
                'nip' => '1234567893',
                'department' => 'Business Administration',
                'major' => 'Management',
                'gender' => 'female',
                'phone' => '081234567893',
                'prodi' => 'Management',
                'fakultas' => 'Business',
                'jabatan' => 'Dosen',
            ],
            [
                'name' => 'Prof. Robert Wilson',
                'username' => 'robertwilson',
                'email' => 'robert.wilson@university.edu',
                'nip' => '1234567894',
                'department' => 'Physics',
                'major' => 'Physics',
                'gender' => 'male',
                'phone' => '081234567894',
                'prodi' => 'Physics',
                'fakultas' => 'Science',
                'jabatan' => 'Professor',
            ],
            [
                'name' => 'Dr. Lisa Brown',
                'username' => 'lisabrown',
                'email' => 'lisa.brown@university.edu',
                'nip' => '1234567895',
                'department' => 'Chemistry',
                'major' => 'Chemistry',
                'gender' => 'female',
                'phone' => '081234567895',
                'prodi' => 'Chemistry',
                'fakultas' => 'Science',
                'jabatan' => 'Dosen',
            ],
            [
                'name' => 'Dr. David Miller',
                'username' => 'davidmiller',
                'email' => 'david.miller@university.edu',
                'nip' => '1234567896',
                'department' => 'Mathematics',
                'major' => 'Mathematics',
                'gender' => 'male',
                'phone' => '081234567896',
                'prodi' => 'Mathematics',
                'fakultas' => 'Science',
                'jabatan' => 'Dosen',
            ],
            [
                'name' => 'Prof. Sarah Garcia',
                'username' => 'sarahgarcia',
                'email' => 'sarah.garcia@university.edu',
                'nip' => '1234567897',
                'department' => 'Biology',
                'major' => 'Biology',
                'gender' => 'female',
                'phone' => '081234567897',
                'prodi' => 'Biology',
                'fakultas' => 'Science',
                'jabatan' => 'Professor',
            ],
            [
                'name' => 'Dr. James Rodriguez',
                'username' => 'jamesrodriguez',
                'email' => 'james.rodriguez@university.edu',
                'nip' => '1234567898',
                'department' => 'History',
                'major' => 'History',
                'gender' => 'male',
                'phone' => '081234567898',
                'prodi' => 'History',
                'fakultas' => 'Humanities',
                'jabatan' => 'Dosen',
            ],
            [
                'name' => 'Dr. Maria Martinez',
                'username' => 'mariamartinez',
                'email' => 'maria.martinez@university.edu',
                'nip' => '1234567899',
                'department' => 'Psychology',
                'major' => 'Psychology',
                'gender' => 'female',
                'phone' => '081234567899',
                'prodi' => 'Psychology',
                'fakultas' => 'Social Sciences',
                'jabatan' => 'Dosen',
            ],
            [
                'name' => 'Prof. William Anderson',
                'username' => 'williamanderson',
                'email' => 'william.anderson@university.edu',
                'nip' => '1234567800',
                'department' => 'Economics',
                'major' => 'Economics',
                'gender' => 'male',
                'phone' => '081234567800',
                'prodi' => 'Economics',
                'fakultas' => 'Business',
                'jabatan' => 'Professor',
            ],
        ];

        foreach ($lecturers as $lecturerData) {
            $user = User::create([
                'name' => $lecturerData['name'],
                'username' => $lecturerData['username'],
                'role' => 'dosen',
                'email' => $lecturerData['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            UserIdentity::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'department' => $lecturerData['department'],
                'major' => $lecturerData['major'],
                'gender' => $lecturerData['gender'],
                'phone' => $lecturerData['phone'],
                'join_date' => now()->subYears(rand(1, 10)),
            ]);

            Lecturer::create([
                'user_id' => $user->id,
                'nip' => $lecturerData['nip'],
                'nama_resmi' => $lecturerData['name'],
                'email_kampus' => $user->email,
                'prodi' => $lecturerData['prodi'],
                'fakultas' => $lecturerData['fakultas'],
                'jabatan' => $lecturerData['jabatan'],
            ]);
        }
    }
}
