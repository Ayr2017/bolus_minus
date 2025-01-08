<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InseminationMethodFactory extends Factory
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
