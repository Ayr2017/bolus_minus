<?php

namespace Database\Factories;

use AllowDynamicProperties;
use App\Models\Organisation;
use App\Models\StructuralUnit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends Factory<Organisation>
 */
#[AllowDynamicProperties] class OrganisationFactory extends Factory
{
    // public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null, ?Collection $recycle = null)
    // {
    //     parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);
    //     $this->structuralUnit = StructuralUnit::factory()->make();
    // }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->company(),
            'structural_unit_id' => StructuralUnit::factory()->create()->id,
            'parent_id' => null,
        ];
    }
}
