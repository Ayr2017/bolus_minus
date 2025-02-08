<?php

namespace Tests;

use App\Models\Bolus;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder']);

        // Пользватели уже созданые в DatabaseSeeder
        $this->admin = tap(User::find(1))?->assignRole('admin');
        $this->user = tap(User::find(2))?->syncRoles([]);
    }
}
