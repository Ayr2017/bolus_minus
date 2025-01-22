<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Database\Factories\OrgaisationFactory;
use Database\Factories\OrganisationFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Organisation::factory(3)->create();
    }
}
