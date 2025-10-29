<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyMouSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('company_mous')->insert([
            [
                'company_id' => 1,
                'mou_number' => 'MOU-2025-001',
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'file_path' => 'mous/mou-2025-001.pdf',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 2,
                'mou_number' => 'MOU-2025-002',
                'start_date' => '2025-02-01',
                'end_date' => '2026-01-31',
                'file_path' => 'mous/mou-2025-002.pdf',
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 3,
                'mou_number' => 'MOU-2024-001',
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'file_path' => 'mous/mou-2024-001.pdf',
                'status' => 'expired',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
