<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CoatColorSeeder extends Seeder
{
    const COAT_COLORS = [
        ['id' => 1, 'name' => 'Черная', 'description' => 'Однотонная черная масть.'],
        ['id' => 2, 'name' => 'Красная', 'description' => 'Однотонная рыжая масть.'],
        ['id' => 3, 'name' => 'Белая', 'description' => 'Однотонная белая масть.'],
        ['id' => 4, 'name' => 'Серая', 'description' => 'Однотонная серая масть.'],
        ['id' => 5, 'name' => 'Бурая', 'description' => 'Однотонная коричневая масть.'],
        ['id' => 6, 'name' => 'Черно-пестрая', 'description' => 'Белая шерсть с черными пятнами.'],
        ['id' => 7, 'name' => 'Красно-пестрая', 'description' => 'Белая шерсть с рыжими пятнами.'],
        ['id' => 8, 'name' => 'Бело-рыжая', 'description' => 'Преимущественно белая с рыжими пятнами.'],
        ['id' => 9, 'name' => 'Пегая', 'description' => 'Крупные пятна разных цветов, обычно черного или рыжего с белым.'],
        ['id' => 10, 'name' => 'Мраморная', 'description' => 'Черная или серая шерсть с белыми вкраплениями, создающими узор.'],
        ['id' => 11, 'name' => 'Тигровая/Палево-пестрая', 'description' => 'Шерсть с чередующимися полосами черного и рыжего цветов.'],
        ['id' => 12, 'name' => 'Дымчатая', 'description' => 'Серый оттенок шерсти с переходами от светлого к темному.'],
        ['id' => 13, 'name' => 'Шутовая', 'description' => 'Смесь черных, рыжих и белых участков шерсти в произвольном порядке.'],
        ['id' => 14, 'name' => 'Рыжая', 'description' => 'Окрашена в рыжие, алые оттенки различной интенсивности.'],
        ['id' => 15, 'name' => 'Темно-красная', 'description' => 'Шкура насыщенного темно-красного оттенка.'],
        ['id' => 16, 'name' => 'Без масти', 'description' => 'Не определено.'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = Carbon::now();

        // Добавляем временные метки ко всем элементам массива
        $dataWithTimestamps = array_map(function ($item) use ($timestamp) {
            return array_merge($item, [
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }, self::COAT_COLORS);

        // Вставка данных с временными метками
        DB::table('coat_colors')->insertOrIgnore($dataWithTimestamps);

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("SELECT SETVAL(pg_get_serial_sequence('coat_colors', 'id'), (SELECT MAX(id) FROM breeds))");
        }
    }
}
