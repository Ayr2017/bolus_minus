<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Organisation;
use App\Models\Status;
use App\Models\Bolus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class AnimalFactory extends Factory
{
    protected $model = Animal::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'number' => strval($this->faker->randomNumber(6)),
            'organisation_id' => Organisation::inRandomOrder()->first()->id,
            'birthday' => $this->faker->dateTimeThisCentury()->format('Y-m-d H:i:s'),
            'breed_id' => Breed::inRandomOrder()->first()->id,
            'number_rshn' => strval($this->faker->randomNumber(6)),
            'bolus_id' => Bolus::inRandomOrder()->first()->id,
            'number_rf' => strval($this->faker->randomNumber(6)),
            'number_tavro' => strval($this->faker->randomNumber(6)),
            'number_tag' => strval($this->faker->randomNumber(6)),
            'tag_color' => $this->faker->colorName(),
            'number_collar' => strval($this->faker->randomNumber(6)),
            'status_id' => Status::inRandomOrder()->first()->id,
            'sex' => $this->faker->randomElement(['male', 'female']),
            'withdrawn_at' => null,
        ];
    }
}
