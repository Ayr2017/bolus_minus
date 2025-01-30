<?php

namespace Database\Factories;

use App\Models\CategoryActive;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrganisationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {

        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->name(),
            'category_actives_id'=> CategoryActive::inRandomOrder()->first()->id,
        ];
    }
}
