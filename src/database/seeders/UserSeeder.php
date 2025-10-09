<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Create an admin user
        User::create([
            'name' => 'System Admin User',
            'username' => 'sysadmin',
            'role' => 'sysadmin',
            'email' => 'sysadmin@example.com',
            'password' => Hash::make('sysadmin'),
        ]);

        // Create a mahasiswa user
        User::create([
            'name' => 'Mahasiswa User',
            'username' => 'mahasiswa',
            'role' => 'mahasiswa',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('mahasiswa'),
        ]);

        // Create a dosen user
        User::create([
            'name' => 'Dosen User',
            'username' => 'dosen',
            'role' => 'dosen',
            'email' => 'dosen@example.com',
            'password' => Hash::make('dosen'),
        ]);

        // Create a management user
        User::create([
            'name' => 'Management User',
            'username' => 'management',
            'role' => 'management',
            'email' => 'management@example.com',
            'password' => Hash::make('management'),
        ]);
    }
}
