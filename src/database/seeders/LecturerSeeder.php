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
        $user = User::create([
            'name' => 'Dr. John Doe',
            'username' => 'johndoe',
            'role' => 'dosen',
            'email' => 'john.doe@university.edu',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        UserIdentity::create([
            'user_id' => '1234567890',
            'email' => $user->email,
            'name' => $user->name,
            'department' => 'Computer Science',
            'major' => 'Informatics',
            'gender' => 'male',
            'phone' => '081234567890',
            'join_date' => now()->subYears(5),
        ]);

        Lecturer::create([
            'user_id' => $user->id,
            'nip' => '1234567890',
            'nama_resmi' => 'Dr. John Doe',
            'email_kampus' => $user->email,
            'prodi' => 'Informatics',
            'fakultas' => 'Computer Science',
            'jabatan' => 'Lecturer',
        ]);
    }
}
