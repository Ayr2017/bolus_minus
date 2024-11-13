<?php

namespace Database\Seeders;

use App\Models\Bolus;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            DefaultUsersSeeder::class,
            StatusesSeeder::class,
            OrganisationsSeeder::class,
            BolusesSeeder::class,
            BreedsSeeder::class,
            AnimalsSeeder::class,
        ]);
    }
}
