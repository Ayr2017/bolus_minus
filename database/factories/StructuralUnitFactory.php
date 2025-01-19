<?php

namespace Database\Factories;

use App\Models\StructuralUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StructuralUnit>
 */
class StructuralUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'uuid' => $this->faker->uuid(),
            'name' => $this->faker->unique()->company(),
            'is_active' => true,
        ];
    }
}
