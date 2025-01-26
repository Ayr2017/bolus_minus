<?php

namespace Database\Seeders;

use App\Models\CategoryActive;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryActiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Молочное','Мясное','Мясо-молочное'];
        foreach ($names as $role) {
            CategoryActive::firstOrCreate(['name' => $role]);

        }
    }
}
