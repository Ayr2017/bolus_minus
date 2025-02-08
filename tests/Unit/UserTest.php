<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    // Обеспечивает откат миграций после каждого теста

    /**
     * Тест на создание пользователя.
     */
    public function test_user_creation()
    {
        $employee = Employee::factory()->create();
        // Создание пользователя с помощью фабрики
        $user = User::factory()->create([
            'current_employee_id' => $employee->id,
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        // Убедимся, что пользователь был успешно создан
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    /**
     * Тест проверки пользователя по email.
     */
    public function test_find_user_by_email()
    {
        // Создание пользователя
        $user = User::factory()->create([
            'email' => 'john@example.com',
        ]);

        // Поиск пользователя по email
        $foundUser = User::where('email', 'john@example.com')->first();

        // Убедимся, что найденный пользователь существует и совпадает с исходным
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }
}
