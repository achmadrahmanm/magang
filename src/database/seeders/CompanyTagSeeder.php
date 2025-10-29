<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('company_tags')->insert([
            [
                'company_id' => 1,
                'tag' => 'Technology',
                'created_at' => now(),
            ],
            [
                'company_id' => 1,
                'tag' => 'Startup',
                'created_at' => now(),
            ],
            [
                'company_id' => 2,
                'tag' => 'Design',
                'created_at' => now(),
            ],
            [
                'company_id' => 2,
                'tag' => 'Creative',
                'created_at' => now(),
            ],
            [
                'company_id' => 3,
                'tag' => 'Finance',
                'created_at' => now(),
            ],
            [
                'company_id' => 3,
                'tag' => 'Corporate',
                'created_at' => now(),
            ],
        ]);
    }
}
