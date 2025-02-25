<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Animal;
use App\Models\Breed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class BreedControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.breeds.index'));
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
        $response = $this->actingAs($this->user)->getJson(route('api.breeds.index'));
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
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.breeds.store'), $data);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'type',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('breeds', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.breeds.store'), $data);

        $response->assertForbidden();
    }

    public function test_show_for_admin()
    {
        $breed = Breed::query()->first();
        $response = $this->actingAs($this->admin)->json('GET', route('api.breeds.show', $breed), ['breed' => $breed->id]);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'breed' => [
                    'id',
                    'name',
                    'type',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'breed' => [
                    'id' => $breed->id,
                    'name' => $breed->name,
                    'type' => $breed->type,
                    'is_active' => $breed->is_active,
                    'created_at' => $breed->created_at,
                    'updated_at' => $breed->updated_at,
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $breed = Breed::query()->first();
        $response = $this->actingAs($this->user)->json('GET', route('api.breeds.show', $breed), ['breed' => $breed->id]);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'breed' => [
                    'id',
                    'name',
                    'type',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'breed' => [
                    'id' => $breed->id,
                    'name' => $breed->name,
                    'type' => $breed->type,
                    'is_active' => $breed->is_active,
                    'created_at' => $breed->created_at,
                    'updated_at' => $breed->updated_at,
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $breed = Breed::query()->first();

        $data = [
            'name' => 'Updated Name',
            'type' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.breeds.update', $breed->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'breed' => [
                    'id',
                    'name',
                    'type',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('breeds', $data);
    }

    public function test_update_for_non_admin()
    {
        $breed = Breed::query()->first();

        $data = [
            'name' => 'Updated Name',
            'type' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.breeds.update', $breed->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'breed' => [
                    'id',
                    'name',
                    'type',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('breeds', $data);
    }

    public function test_destroy_for_admin()
    {
        $item = Breed::factory()->create();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.breeds.destroy', $item));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('breeds', ['id' => $item->id]);
    }

    public function test_destroy_with_relations_disabled_for_admin()
    {
        $item = Breed::query()->first();
        Animal::factory()->create(['breed_id' => $item->id]);

        $response = $this->actingAs($this->admin)->deleteJson(route('api.breeds.destroy', $item));
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'data' => null,
        ]);

        $this->assertDatabaseHas('breeds', ['id' => $item->id]);
    }

    public function test_destroy_forbidden_for_non_admin()
    {
        $item = Breed::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.breeds.destroy', $item->id));
        $response->assertForbidden();
        $this->assertDatabaseHas('breeds', ['id' => $item->id]);
    }

    public function test_destroy_with_relations_forbidden_for_non_admin()
    {
        $item = Breed::query()->first();
        Animal::factory()->create(['breed_id' => $item->id]);

        $response = $this->actingAs($this->user)->deleteJson(route('api.breeds.destroy', $item));
        $response->assertForbidden();
        $this->assertDatabaseHas('breeds', ['id' => $item->id]);
    }
}
