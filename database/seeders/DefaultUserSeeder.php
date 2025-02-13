<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    public function __construct()
    {
        $this->admin = [
            'name' => 'SuperAdmin',
            'email' => config('seed.admin_email'),
            'password' => config('seed.admin_password'),
            'phone' => config('seed.admin_phone'),
        ];
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($this->admin['email'] && $this->admin['password']) {
            $user = User::firstOrCreate(
                ['email' => $this->admin['email']],
                [
                    'name' => $this->admin['name'],
                    'password' => Hash::make($this->admin['password']),
                    'email_verified_at' => date("Y-m-d H:i:s"),
                ]
            );

            $user->assignRole('super-admin');
            $user->assignRole('admin');
        }
    }
}
