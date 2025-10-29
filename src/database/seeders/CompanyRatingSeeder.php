<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('company_ratings')->insert([
            [
                'company_id' => 1,
                'rating' => 5,
                'notes' => 'Excellent internship program and supportive environment.',
                'rated_by' => 1,
                'created_at' => now(),
            ],
            [
                'company_id' => 1,
                'rating' => 4,
                'notes' => 'Good learning opportunities.',
                'rated_by' => 2,
                'created_at' => now(),
            ],
            [
                'company_id' => 2,
                'rating' => 4,
                'notes' => 'Creative and fun workplace.',
                'rated_by' => 1,
                'created_at' => now(),
            ],
            [
                'company_id' => 3,
                'rating' => 3,
                'notes' => 'Professional but could improve communication.',
                'rated_by' => 1,
                'created_at' => now(),
            ],
        ]);
    }
}
