<?php

namespace Database\Seeders;

use App\Models\Bolus;
// use App\Models\CategoryActive;
use App\Models\Employee;
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
            RoleSeeder::class,
            DefaultUserSeeder::class,
            StatusSeeder::class,
            BreedSeeder::class,
            HerdEntryReasonSeeder::class,
            AnimalGroupSeeder::class,
            RestrictionReasonSeeder::class,
            InseminationMethodSeeder::class,
            SemenPortionSeeder::class,
            ZootechnicalExitReasonSeeder::class,
            CoatColorSeeder::class,
            TagColorSeeder::class,
            OrganisationSeeder::class,
            BolusSeeder::class,
            AnimalSeeder::class,
            EmployeeSeeder::class,
            UserSeeder::class,
        ]);
    }
}
