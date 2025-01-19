<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\RestrictionReason;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

#[AllowDynamicProperties] class RestrictionReasonsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.restriction-reasons.index'));
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
        $response = $this->actingAs($this->user)->getJson(route('api.restriction-reasons.index'));
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
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.restriction-reasons.store'), $data);
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

        $this->assertDatabaseHas('restriction_reasons', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.restriction-reasons.store'), $data);
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

        $this->assertDatabaseHas('restriction_reasons', $data);
    }

    public function test_show_for_admin()
    {
        $restrictionReason = RestrictionReason::query()->first();
        $response = $this->actingAs($this->admin)->getJson(route('api.restriction-reasons.show', $restrictionReason));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'restrictionReason' => [
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
                'restrictionReason' => [
                    'id' => $restrictionReason->id,
                    'name' => $restrictionReason->name,
                    'description' => $restrictionReason->description,
                    'is_active' => $restrictionReason->is_active,
                    'created_at' => $restrictionReason->created_at,
                    'updated_at' => $restrictionReason->updated_at,
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $restrictionReason = RestrictionReason::query()->first();
        $response = $this->actingAs($this->user)->getJson(route('api.restriction-reasons.show', $restrictionReason));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'restrictionReason' => [
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
                'restrictionReason' => [
                    'id' => $restrictionReason->id,
                    'name' => $restrictionReason->name,
                    'description' => $restrictionReason->description,
                    'is_active' => $restrictionReason->is_active,
                    'created_at' => $restrictionReason->created_at,
                    'updated_at' => $restrictionReason->updated_at,
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $restrictionReason = RestrictionReason::query()->first();

        $requestData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $responseData = Arr::except($requestData, ['restriction_reason']);

        $response = $this->actingAs($this->admin)->putJson(route('api.restriction-reasons.update', $restrictionReason->id), $requestData);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                "restrictionReason" => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('restriction_reasons', $responseData);
    }

    public function test_update_for_non_admin()
    {
        $restrictionReason = RestrictionReason::query()->first();

        $requestData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $responseData = Arr::except($requestData, ['restriction_reason']);

        $response = $this->actingAs($this->user)->putJson(route('api.restriction-reasons.update', $restrictionReason->id), $requestData);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                "restrictionReason" => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ]
            ],
        ]);

        $this->assertDatabaseHas('restriction_reasons', $responseData);
    }

    public function test_destroy_for_admin()
    {
        $restrictionReason = RestrictionReason::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.restriction-reasons.destroy', $restrictionReason->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('restriction_reasons', ['id' => $restrictionReason->id]);
    }

    public function test_destroy_for_non_admin()
    {
        $restrictionReason = RestrictionReason::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.restriction-reasons.destroy', $restrictionReason->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('restriction_reasons', ['id' => $restrictionReason->id]);
    }
}
