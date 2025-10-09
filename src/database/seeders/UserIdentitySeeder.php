<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserIdentity;

class UserIdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $identities = [
            [
                'user_id' => 'ADMIN001',
                'email' => 'sysadmin@example.com',
                'campus_id' => 'CAMPUS01',
                'department' => 'Information Technology',
                'major' => 'System Administration',
                'name' => 'System Admin User',
                'gender' => 'male',
                'dob' => '1985-05-15',
                'phone' => '+62-811-1111-1111',
                'image' => null,
                'join_date' => '2020-01-01',
                'sks_score' => 0,
            ],
            [
                'user_id' => '2021001234',
                'email' => 'mahasiswa@example.com',
                'campus_id' => 'CAMPUS01',
                'department' => 'Computer Science',
                'major' => 'Software Engineering',
                'name' => 'Mahasiswa User',
                'gender' => 'male',
                'dob' => '2003-08-20',
                'phone' => '+62-812-3456-7890',
                'image' => null,
                'join_date' => '2021-09-01',
                'sks_score' => 98,
            ],
            [
                'user_id' => 'DSN001',
                'email' => 'dosen@example.com',
                'campus_id' => 'CAMPUS01',
                'department' => 'Computer Science',
                'major' => 'Computer Science',
                'name' => 'Dosen User',
                'gender' => 'female',
                'dob' => '1978-12-10',
                'phone' => '+62-813-9876-5432',
                'image' => null,
                'join_date' => '2015-08-01',
                'sks_score' => 0,
            ],
            [
                'user_id' => 'MGT001',
                'email' => 'management@example.com',
                'campus_id' => 'CAMPUS01',
                'department' => 'Management',
                'major' => 'Academic Management',
                'name' => 'Management User',
                'gender' => 'male',
                'dob' => '1970-03-25',
                'phone' => '+62-814-5555-5555',
                'image' => null,
                'join_date' => '2010-01-01',
                'sks_score' => 0,
            ],
        ];

        foreach ($identities as $identity) {
            UserIdentity::create($identity);
        }
    }
}
