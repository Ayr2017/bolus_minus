<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class InseminationMethodSeeder extends Seeder
{
    const INSEMINATION_METHODS = [
        ['id' => 1, 'name' => 'Традиционным семенем'],
        ['id' => 2, 'name' => 'Сексированное семя'],
        ['id' => 3, 'name' => 'Вольная случка'],
        ['id' => 4, 'name' => 'Ручная случка'],
        ['id' => 5, 'name' => 'Трансплантация эмбрионов'],
        ['id' => 6, 'name' => 'Трансплантация эмбрионов (с манип.)'],
        ['id' => 7, 'name' => 'Трансплантация эмбрионов (сом.клоны)'],

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
        }, self::INSEMINATION_METHODS);

        // Вставка данных с временными метками
        DB::table('insemination_methods')->insertOrIgnore($dataWithTimestamps);

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("SELECT SETVAL(pg_get_serial_sequence('insemination_methods', 'id'), (SELECT MAX(id) FROM breeds))");
        }
    }
}
