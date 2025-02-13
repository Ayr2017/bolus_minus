<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\InseminationMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class InseminationMethodControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.insemination-methods.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                ],
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
        $response = $this->actingAs($this->user)->getJson(route('api.insemination-methods.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                ],
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
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.insemination-methods.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('insemination_methods', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.insemination-methods.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('insemination_methods', $data);
    }

    public function test_show_for_admin()
    {
        $item = InseminationMethod::query()->first();
        $response = $this->actingAs($this->admin)->json('GET', route('api.insemination-methods.show', $item));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'is_active' => $item->is_active,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $item = InseminationMethod::query()->first();
        $response = $this->actingAs($this->user)->json('GET', route('api.insemination-methods.show', $item));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'is_active' => $item->is_active,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $item = InseminationMethod::query()->first();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.insemination-methods.update', $item->id), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('insemination_methods', $data);
    }

    public function test_update_for_non_admin()
    {
        $item = InseminationMethod::query()->first();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.insemination-methods.update', $item->id), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('insemination_methods', $data);
    }

    public function test_destroy_for_admin()
    {
        $item = InseminationMethod::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.insemination-methods.destroy', $item->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('insemination_methods', ['id' => $item->id]);
    }

    public function test_destroy_for_non_admin()
    {
        $item = InseminationMethod::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.insemination-methods.destroy', $item->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('insemination_methods', ['id' => $item->id]);
    }
}
