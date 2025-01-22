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
            BreedsSeeder::class,
            AnimalGroupsSeeder::class,
            RestrictionReasonsSeeder::class,
            InseminationMethodsSeeder::class,
            SemenPortionSeeder::class,
            ZootechnicalExitReasonSeeder::class,
            CoatColorSeeder::class,
            TagColorSeeder::class,
            OrganisationSeeder::class,
        ]);
    }
}
