<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RestrictionReasonSeeder extends Seeder
{
    const RESTRICTION_REASONS = [
        ['id' => 1, 'name' => 'Возраст'],
        ['id' => 2, 'name' => 'Запуск'],
        ['id' => 3, 'name' => 'Диагноз'],
        ['id' => 4, 'name' => 'Вакцинация и медикаменты'],
        ['id' => 5, 'name' => 'Обработка'],
        ['id' => 6, 'name' => 'Сервис период'],
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
        }, self::RESTRICTION_REASONS);

        // Вставка данных с временными метками
        DB::table('restriction_reasons')->insertOrIgnore($dataWithTimestamps);

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("SELECT SETVAL(pg_get_serial_sequence('restriction_reasons', 'id'), (SELECT MAX(id) FROM breeds))");
        }
    }
}
