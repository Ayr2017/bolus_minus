<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organisation;
use App\Enums\EquipmentType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MilkingEquipment>
 */
class MilkingEquipmentFactory extends Factory
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
            'equipment_type' => fake()->randomElement(array_column(EquipmentType::cases(), 'value')),
            'milking_places_amount' => fake()->randomNumber(),
        ];
    }
}
