<?php

namespace Database\Seeders;

use App\Models\HerdEntryReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HerdEntryReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HerdEntryReason::factory(3)->create();
    }
}
