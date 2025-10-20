<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+3 months');
        $endDate = $this->faker->dateTimeBetween($startDate, '+8 months');
        
        return [
            'institution_name' => $this->faker->company(),
            'institution_address' => $this->faker->address(),
            'business_field' => $this->faker->randomElement([
                'Teknologi Informasi',
                'Perbankan dan Keuangan',
                'E-commerce',
                'Transportation & Logistics',
                'Telekomunikasi',
                'Manufaktur',
                'Konsultan IT',
                'Startup Technology'
            ]),
            'placement_division' => $this->faker->randomElement([
                'Software Development',
                'Data Science',
                'IT Security',
                'Backend Engineering',
                'Frontend Development',
                'Mobile Development',
                'DevOps',
                'Quality Assurance'
            ]),
            'planned_start_date' => $startDate,
            'planned_end_date' => $endDate,
            'notes' => $this->faker->optional(0.7)->paragraph(),
            'status' => $this->faker->randomElement(['submitted', 'reviewing', 'approved', 'rejected']),
            'status_note' => $this->faker->optional(0.3)->sentence(),
            'rejection_reason' => null,
            'submitted_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the application is submitted.
     */
    public function submitted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'submitted',
            'reviewed_by' => null,
            'reviewed_at' => null,
            'rejection_reason' => null,
        ]);
    }

    /**
     * Indicate that the application is under review.
     */
    public function reviewing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'reviewing',
            'reviewed_by' => User::factory(),
            'reviewed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'rejection_reason' => null,
        ]);
    }

    /**
     * Indicate that the application is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'reviewed_by' => User::factory(),
            'reviewed_at' => $this->faker->dateTimeBetween('-2 weeks', '-1 week'),
            'rejection_reason' => null,
        ]);
    }

    /**
     * Indicate that the application is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'reviewed_by' => User::factory(),
            'reviewed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'rejection_reason' => $this->faker->sentence(),
        ]);
    }
}