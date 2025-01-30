<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bolus;

class BolusesSeeder extends Seeder
{
    const BOLUS_IDS = [
        'bd63627b-9a71-497b-b147-e3e1fb3d8b8e',
        '42c39338-7299-4344-847b-1f6a86f78f27',
        '1abd036b-9b03-4dec-afa2-b1119f467cce',
        'c1d3427a-0a05-4123-a1c8-af310bec4e02',
        '9173dcd0-c172-43e1-8bde-159e8014ac6c',
    ];

    public function run(): void
    {
        foreach (self::BOLUS_IDS as $key => $bolus_id) {
            Bolus::query()->firstOrCreate(['device_number' => $bolus_id],
                [
                    'number' => str_pad($key, 6, '0', STR_PAD_LEFT),
                    'version' => 1,
                    'batch_number' => 1,
                    'produced_at' => now(),
                    'active' => true,
                ]
            );
        }
    }
}
