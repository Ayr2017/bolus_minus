<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(2)->create();

        // Админ создается ранее в DefaultUsersSeeder
        // User::create([
        //     'name' => 'Admin',
        //     'email' => env('ADMIN_EMAIL'),
        //     'password' => env('ADMIN_PASSWORD'),
        //     'phone' => env('ADMIN_PHONE'),
        // ]);
    }
}
