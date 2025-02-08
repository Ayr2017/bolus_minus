<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\StructuralUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class StructuralUnitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --class=StructuralUnitSeeder');
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.structural-units.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'uuid',
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
        $response = $this->actingAs($this->user)->getJson(route('api.structural-units.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'uuid',
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
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.structural-units.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'uuid',
                'description',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('structural_units', $data);
    }

    public function test_store_forbidden_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.structural-units.store'), $data);
        $response->assertForbidden();
        $this->assertDatabaseMissing('structural_units', $data);
    }

    public function test_show_for_admin()
    {
        $item = StructuralUnit::factory()->create();
        $response = $this->actingAs($this->admin)->json('GET', route('api.structural-units.show', $item));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'uuid',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $item->id,
                'uuid' => $item->uuid->toString(),
                'name' => $item->name,
                'description' => $item->description,
                'is_active' => $item->is_active,
                'created_at' => $item->created_at->toDateTimeString(),
                'updated_at' => $item->updated_at->toDateTimeString(),
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $item = StructuralUnit::factory()->create();
        $response = $this->actingAs($this->user)->json('GET', route('api.structural-units.show', $item));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'uuid',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);
        $response->assertJson([
            'data' => [
                'id' => $item->id,
                'uuid' => $item->uuid->toString(),
                'name' => $item->name,
                'description' => $item->description,
                'is_active' => $item->is_active,
                'created_at' => $item->created_at->toDateTimeString(),
                'updated_at' => $item->updated_at->toDateTimeString(),
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $item = StructuralUnit::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.structural-units.update', $item->id), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'structuralUnit' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('structural_units', $data);
    }

    public function test_update_forbidden_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $item = StructuralUnit::create($data);

        $updatedData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.structural-units.update', $item), $updatedData);
        $response->assertForbidden();
        $this->assertDatabaseHas('structural_units', $data);
    }

    public function test_destroy_for_admin()
    {
        $item = StructuralUnit::factory()->create();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.structural-units.destroy', $item));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('structural_units', ['id' => $item->id]);
    }

    public function test_destroy_forbidden_for_non_admin()
    {
        $item = StructuralUnit::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson(route('api.structural-units.destroy', $item));

        $response->assertForbidden();

        $this->assertDatabaseHas('structural_units', ['id' => $item->id]);
    }
}
