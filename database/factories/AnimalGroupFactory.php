<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnimalGroupFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->name(),
        ];
    }
}
