<?php

namespace Controllers\Api;

use AllowDynamicProperties;
use App\Models\Animal;
use App\Models\AnimalGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;


#[AllowDynamicProperties] class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.users.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items',
                'current_page',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]
        ]);
    }

    public function test_index_for_non_admin()
    {
        $response = $this->actingAs($this->user)->getJson(route('api.users.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items',
                'current_page',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]
        ]);
    }

    public function test_store_for_admin()
    {
        $data = [
            'name' => 'Test Name',
            'email' => 'test@test.com',
            'password' => 'TestPassword',
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.users.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'surname',
                'email',
                'phone',
                'is_active',
                'created_at',
                'updated_at',
                'lastname',
                'roles',
                'organisations',
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test Name',
            'email' => 'test@test.com',
            'is_active' => 1,
        ]);

        $user = User::where('email', 'test@test.com')->first();
        $this->assertTrue(Hash::check('TestPassword', $user->password));
    }

    public function test_store_forbidden_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'email' => 'test@test.com',
            'password' => 'TestPassword',
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.users.store'), $data);
        $response->assertForbidden();
        $this->assertDatabaseMissing('users', $data);
    }

    public function test_show_for_admin()
    {
        $item = User::query()->first();

        $response = $this->actingAs($this->admin)->json('GET', route('api.users.show', $item));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'surname',
                'email',
                'phone',
                'is_active',
                'created_at',
                'updated_at',
                'lastname',
                'roles',
                'organisations',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $item->id,
                'name' => $item->name,
                'surname' => $item->surname,
                'email' => $item->email,
                'phone' => $item->phone,
                'is_active' => $item->is_active,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'lastname' => $item->lastname,
                'roles' => $item->getRoleNames()->toArray(),
                'organisations' => $item->employees->pluck('organisation')->toArray(),
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $item = User::query()->first();

        $response = $this->actingAs($this->user)->json('GET', route('api.users.show', $item));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'surname',
                'email',
                'phone',
                'is_active',
                'created_at',
                'updated_at',
                'lastname',
                'roles',
                'organisations',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $item->id,
                'name' => $item->name,
                'surname' => $item->surname,
                'email' => $item->email,
                'phone' => $item->phone,
                'is_active' => $item->is_active,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'lastname' => $item->lastname,
                'roles' => $item->getRoleNames()->toArray(),
                'organisations' => $item->employees->pluck('organisation')->toArray(),
            ]
        ]);
    }


    public function test_update_for_admin()
    {
        $item = User::query()->first();

        $updatedData = [
            'name' => 'Updated Test Name',
            'email' => 'updated@test.com',
            'password' => 'UpdatedPassword',
            'is_active' => 0,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.users.update', $item), $updatedData);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'surname',
                'email',
                'phone',
                'is_active',
                'created_at',
                'updated_at',
                'lastname',
                'roles',
                'organisations',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $item->id,
                'name' => $updatedData['name'],
                'surname' => $item->surname,
                'email' => $updatedData['email'],
                'phone' => $item->phone,
                'is_active' => $updatedData['is_active'],
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'lastname' => $item->lastname,
                'roles' => $item->getRoleNames()->toArray(),
                'organisations' => $item->employees->pluck('organisation')->toArray(),
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Updated Test Name',
            'email' => 'updated@test.com',
            'is_active' => 0,
        ]);

        $user = User::where('email', 'updated@test.com')->first();
        $this->assertTrue(Hash::check('UpdatedPassword', $user->password));
    }

    public function test_update_for_non_admin()
    {
        $item = User::query()->first();

        $updatedData = [
            'name' => 'Updated Test Name',
            'email' => 'updated@test.com',
            'password' => 'UpdatedPassword',
            'is_active' => 0,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.users.update', $item), $updatedData);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'surname',
                'email',
                'phone',
                'is_active',
                'created_at',
                'updated_at',
                'lastname',
                'roles',
                'organisations',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $item->id,
                'name' => $updatedData['name'],
                'surname' => $item->surname,
                'email' => $updatedData['email'],
                'phone' => $item->phone,
                'is_active' => $updatedData['is_active'],
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'lastname' => $item->lastname,
                'roles' => $item->getRoleNames()->toArray(),
                'organisations' => $item->employees->pluck('organisation')->toArray(),
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Updated Test Name',
            'email' => 'updated@test.com',
            'is_active' => 0,
        ]);

        $user = User::where('email', 'updated@test.com')->first();
        $this->assertTrue(Hash::check('UpdatedPassword', $user->password));
    }

    // TODO: уточнить, может ли админ удалить свой аккаунт и чужие
    public function test_destroy_for_admin()
    {
        $item = User::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.users.destroy', $item));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('users', ['id' => $item->id]);
    }

    // TODO: уточнить, может ли пользователь удалить свой аккаунт и чужие
    public function test_destroy_forbidden_for_admin()
    {
        $item = User::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.users.destroy', $item));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('users', ['id' => $item->id]);
    }
}
