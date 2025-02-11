<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HerdEntryReason>
 */
class HerdEntryReasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = ['Покупка', 'Рождение на предприятии', 'Перевод с другого предприятия/отделения',];

        return [
            'name'=>fake()->randomElement($data),
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean()
        ];
    }
}
