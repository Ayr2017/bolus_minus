<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bolus;

class BolusesSeeder extends Seeder
{
    const BOLUS_IDS = [
        'da066633-77d3-43a5-898e-36fb14175a3d',
        'd9b3c96c-c820-4ba2-bdf8-58e1e51303a9',
        '9e7a2458-9981-4aff-812f-3271cf43a52b',
        '1ec4c6fe-6745-43bf-8e88-19e33c56ca4d',
        '4a0b4a2f-9e96-4f21-96dc-1efb54b28ae0',
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
