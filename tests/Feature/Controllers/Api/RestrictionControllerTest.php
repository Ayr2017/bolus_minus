<?php

namespace Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Restriction;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

#[AllowDynamicProperties] class RestrictionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        Restriction::factory()->count(10)->create();
    }

    //TODO: fillable не соответствует полям в миграции, поэтому тесты не проходят -> исправить миграцию или fillable
    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.restrictions.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items',
                "current_page",
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
        $response = $this->actingAs($this->user)->getJson(route('api.restrictions.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items',
                "current_page",
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

        $response = $this->actingAs($this->admin)->postJson(route('api.restrictions.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'title',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('restrictions', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.restrictions.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'title',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('restrictions', $data);
    }

    public function test_show_for_admin()
    {
        $restriction = Restriction::query()->first();
        $response = $this->actingAs($this->admin)->json('GET', route('api.restrictions.show', $restriction), ['restriction' => $restriction->id]);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'restriction' => [
                    'id',
                    'name',
                    'title',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'restriction' => [
                    'id' => $restriction->id,
                    'name' => $restriction->name,
                    'title' => $restriction->title,
                    'is_active' => $restriction->is_active,
                    'created_at' => $restriction->created_at,
                    'updated_at' => $restriction->updated_at,
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $restriction = Restriction::query()->first();
        $response = $this->actingAs($this->user)->json('GET', route('api.restrictions.show', $restriction), ['restriction' => $restriction->id]);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'restriction' => [
                    'id',
                    'name',
                    'title',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'restriction' => [
                    'id' => $restriction->id,
                    'name' => $restriction->name,
                    'title' => $restriction->title,
                    'is_active' => $restriction->is_active,
                    'created_at' => $restriction->created_at,
                    'updated_at' => $restriction->updated_at,
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $restriction = Restriction::query()->first();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.restrictions.update', $restriction->id), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                "restriction" => [
                    'id',
                    'name',
                    'title',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('restrictions', $data);
    }

    public function test_update_for_non_admin()
    {
        $restriction = Restriction::query()->first();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.restrictions.update', $restriction->id), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                "restriction" => [
                    'id',
                    'name',
                    'title',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('restrictions', $data);
    }

    public function test_destroy_for_admin()
    {
        $restriction = Restriction::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.restrictions.destroy', $restriction->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('restrictions', ['id' => $restriction->id]);
    }

    public function test_destroy_for_non_admin()
    {
        $restriction = Restriction::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.restrictions.destroy', $restriction->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('restrictions', ['id' => $restriction->id]);
    }
}
