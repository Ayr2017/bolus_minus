<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organisation;
use App\Models\Shift;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Milking>
 */
class MilkingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'organization_id' => Organisation::query()->inRandomOrder()->first()->id,
            'department_id' => Organisation::query()->inRandomOrder()->first()->id,
            'shift_id' => Shift::query()->inRandomOrder()->first()->id,
            'start_time' => fake()->time('H:i'),
            'end_time' => fake()->time('H:i'),
        ];
    }
}
