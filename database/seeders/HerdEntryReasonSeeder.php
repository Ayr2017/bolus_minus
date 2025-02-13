<?php

namespace Database\Seeders;

use App\Models\HerdEntryReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HerdEntryReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HerdEntryReason::insert([
            ['name' => 'Покупка'],
            ['name' => 'Рождение на предприятии'],
            ['name' => 'Перевод с другого предприятия/отделения']
        ]);
    }
}
