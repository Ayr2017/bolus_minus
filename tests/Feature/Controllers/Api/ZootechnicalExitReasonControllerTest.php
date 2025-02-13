<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\RestrictionReason;
use App\Models\ZootechnicalExitReason;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

#[AllowDynamicProperties] class ZootechnicalExitReasonControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.zootechnical-exit-reasons.index'));
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
        $response = $this->actingAs($this->user)->getJson(route('api.zootechnical-exit-reasons.index'));
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

        $response = $this->actingAs($this->admin)->postJson(route('api.zootechnical-exit-reasons.store'), $data);
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
            ],
        ]);

        $this->assertDatabaseHas('zootechnical_exit_reasons', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.zootechnical-exit-reasons.store'), $data);
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
            ],
        ]);

        $this->assertDatabaseHas('zootechnical_exit_reasons', $data);
    }

    public function test_show_for_admin()
    {
        $zootechnicalExitReason = ZootechnicalExitReason::query()->first();
        $response = $this->actingAs($this->admin)->getJson(route('api.zootechnical-exit-reasons.show', $zootechnicalExitReason));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'zootechnicalExitReason' => [
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
                'zootechnicalExitReason' => [
                    'id' => $zootechnicalExitReason->id,
                    'name' => $zootechnicalExitReason->name,
                    'description' => $zootechnicalExitReason->description,
                    'is_active' => $zootechnicalExitReason->is_active,
                    'created_at' => $zootechnicalExitReason->created_at,
                    'updated_at' => $zootechnicalExitReason->updated_at,
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $zootechnicalExitReason = ZootechnicalExitReason::query()->first();
        $response = $this->actingAs($this->user)->getJson(route('api.zootechnical-exit-reasons.show', $zootechnicalExitReason));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'zootechnicalExitReason' => [
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
                'zootechnicalExitReason' => [
                    'id' => $zootechnicalExitReason->id,
                    'name' => $zootechnicalExitReason->name,
                    'description' => $zootechnicalExitReason->description,
                    'is_active' => $zootechnicalExitReason->is_active,
                    'created_at' => $zootechnicalExitReason->created_at,
                    'updated_at' => $zootechnicalExitReason->updated_at,
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $zootechnicalExitReason = ZootechnicalExitReason::query()->first();

        $restrictionReason = RestrictionReason::query()->first();

        $requestData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
            'restriction_reason' => $restrictionReason->id,
        ];

        $responseData = Arr::except($requestData, ['restriction_reason']);

        $response = $this->actingAs($this->admin)->putJson(route('api.zootechnical-exit-reasons.update', $zootechnicalExitReason->id), $requestData);

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

        $this->assertDatabaseHas('zootechnical_exit_reasons', $responseData);
    }

    public function test_update_for_non_admin()
    {
        $zootechnicalExitReason = ZootechnicalExitReason::query()->first();

        $restrictionReason = RestrictionReason::query()->first();

        $requestData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
            'restriction_reason' => $restrictionReason->id,
        ];

        $responseData = Arr::except($requestData, ['restriction_reason']);

        $response = $this->actingAs($this->user)->putJson(route('api.zootechnical-exit-reasons.update', $zootechnicalExitReason->id), $requestData);

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

        $this->assertDatabaseHas('zootechnical_exit_reasons', $responseData);
    }

    public function test_destroy_for_admin()
    {
        $zootechnicalExitReason = ZootechnicalExitReason::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.zootechnical-exit-reasons.destroy', $zootechnicalExitReason->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('zootechnical_exit_reasons', ['id' => $zootechnicalExitReason->id]);
    }

    public function test_destroy_for_non_admin()
    {
        $zootechnicalExitReason = ZootechnicalExitReason::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.zootechnical-exit-reasons.destroy', $zootechnicalExitReason->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('zootechnical_exit_reasons', ['id' => $zootechnicalExitReason->id]);
    }
}
