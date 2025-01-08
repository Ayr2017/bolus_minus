<?php

namespace Database\Seeders;

use App\Models\TagColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TagColor::insert([
            ['name' => 'Черный', 'slug' => 'black', 'hex' => '#000000'], // Black
            ['name' => 'Белый', 'slug' => 'white', 'hex' => '#FFFFFF'], // White
            ['name' => 'Красный', 'slug' => 'red', 'hex' => '#FF0000'], // Red
            ['name' => 'Синий', 'slug' => 'blue', 'hex' => '#0000FF'], // Blue
            ['name' => 'Желтый', 'slug' => 'yellow', 'hex' => '#FFFF00'], // Yellow
            ['name' => 'Фиолетовый', 'slug' => 'purple', 'hex' => '#800080'], // Purple
            ['name' => 'Розовый', 'slug' => 'pink', 'hex' => '#FFC0CB'], // Pink
            ['name' => 'Серый', 'slug' => 'gray', 'hex' => '#808080'], // Gray
            ['name' => 'Зеленый', 'slug' => 'green', 'hex' => '#008000'], // Green
            ['name' => 'Коричневый', 'slug' => 'brown', 'hex' => '#A52A2A'], // Brown
        ]);
    }
}
