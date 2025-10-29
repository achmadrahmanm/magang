<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('company_contacts')->insert([
            [
                'company_id' => 1,
                'name' => 'John Doe',
                'email' => 'john@teknologimaju.com',
                'phone' => '+62 812 3456 7890',
                'role_title' => 'HR Manager',
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 1,
                'name' => 'Jane Smith',
                'email' => 'jane@teknologimaju.com',
                'phone' => '+62 811 9876 5432',
                'role_title' => 'IT Manager',
                'is_primary' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 2,
                'name' => 'Bob Wilson',
                'email' => 'bob@kreatifdesign.id',
                'phone' => '+62 813 4567 8901',
                'role_title' => 'Creative Director',
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 3,
                'name' => 'Alice Brown',
                'email' => 'alice@finansialaman.com',
                'phone' => '+62 814 5678 9012',
                'role_title' => 'Finance Director',
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
