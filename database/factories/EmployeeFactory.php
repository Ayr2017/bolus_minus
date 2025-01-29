<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->name(),
            'position' => fake()->name(),
            'organisation_id' => Organisation::inRandomOrder()->first()->id,
            'user_id' => Employee::inRandomOrder()->first()->id,
            'is_active' => fake()->boolean(),
        ];
    }
}
