<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SemenPortionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean()
        ];
    }
}
