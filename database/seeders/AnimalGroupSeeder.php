<?php

namespace Database\Seeders;

use App\Models\AnimalGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalGroupSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animalGroups = [
            ['id' => 1, 'name' => 'Телята'],
            ['id' => 2, 'name' => 'Телки'],
            ['id' => 3, 'name' => 'Первотелки'],
            ['id' => 4, 'name' => 'Раздой'],
            ['id' => 5, 'name' => 'Дойные'],
            ['id' => 6, 'name' => 'Сухостойные'],
            ['id' => 7, 'name' => 'Выбывшие (выбракована)'],
            ['id' => 8, 'name' => 'Быки'],
        ];

        foreach ($animalGroups as $animalGroup) {
            AnimalGroup::firstOrcreate([
                'id' => $animalGroup['id'],
            ], $animalGroup);
        }
    }
}
