<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('companies')->insert([
            [
                'name' => 'PT Teknologi Maju',
                'address' => 'Jl. Sudirman No. 123, Jakarta',
                'business_field' => 'Technology',
                'placement_divisions' => 'IT, Software Development',
                'website' => 'https://teknologimaju.com',
                'is_verified' => true,
                'status' => 'active',
                'source' => 'campus',
                'notes' => 'Leading tech company',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV Kreatif Design',
                'address' => 'Jl. Malioboro No. 45, Yogyakarta',
                'business_field' => 'Design',
                'placement_divisions' => 'Graphic Design, UI/UX',
                'website' => 'https://kreatifdesign.id',
                'is_verified' => false,
                'status' => 'active',
                'source' => 'student',
                'notes' => 'Creative design studio',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT Finansial Aman',
                'address' => 'Jl. Thamrin No. 67, Jakarta',
                'business_field' => 'Finance',
                'placement_divisions' => 'Accounting, Finance',
                'website' => 'https://finansialaman.com',
                'is_verified' => true,
                'status' => 'inactive',
                'source' => 'partner',
                'notes' => 'Financial services company',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
