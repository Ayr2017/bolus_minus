<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\HerdEntryReason;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Animal;

#[AllowDynamicProperties] class HerdEntryReasonsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.herd-entry-reasons.index'));
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
        $response = $this->actingAs($this->user)->getJson(route('api.herd-entry-reasons.index'));
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

        $response = $this->actingAs($this->admin)->postJson(route('api.herd-entry-reasons.store'), $data);
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

        $this->assertDatabaseHas('herd_entry_reasons', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.herd-entry-reasons.store'), $data);
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

        $this->assertDatabaseHas('herd_entry_reasons', $data);
    }

    public function test_show_for_admin()
    {
        $item = HerdEntryReason::query()->first();
        $response = $this->actingAs($this->admin)->json('GET', route('api.herd-entry-reasons.show', $item));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'herdEntryReason' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'herdEntryReason' => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'is_active' => $item->is_active,
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $item = HerdEntryReason::query()->first();
        $response = $this->actingAs($this->user)->json('GET', route('api.herd-entry-reasons.show', $item));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'herdEntryReason' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'herdEntryReason' => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'description' => $item->description,
                    'is_active' => $item->is_active,
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $item = HerdEntryReason::query()->first();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.herd-entry-reasons.update', $item->id), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'herdEntryReason' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                ]
            ],
        ]);

        $this->assertDatabaseHas('herd_entry_reasons', $data);
    }

    public function test_update_for_non_admin()
    {
        $item = HerdEntryReason::query()->first();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.herd-entry-reasons.update', $item->id), $data);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'herdEntryReason' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                ]
            ],
        ]);

        $this->assertDatabaseHas('herd_entry_reasons', $data);
    }

    public function test_destroy_for_admin()
    {
        $item = HerdEntryReason::factory()->create();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.herd-entry-reasons.destroy', $item));
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('herd_entry_reasons', ['id' => $item->id]);
    }

    public function test_destroy_with_relations_disabled_for_admin()
    {
        $item = HerdEntryReason::query()->first();
        Animal::factory()->create(['herd_entry_reason_id' => $item->id]);

        $response = $this->actingAs($this->admin)->deleteJson(route('api.herd-entry-reasons.destroy', $item));
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'data' => null,
        ]);

        $this->assertDatabaseHas('herd_entry_reasons', ['id' => $item->id]);
    }

    public function test_destroy_for_non_admin()
    {
        $item = HerdEntryReason::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson(route('api.herd-entry-reasons.destroy', $item));
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('herd_entry_reasons', ['id' => $item->id]);
    }

    public function test_destroy_with_relations_disabled_for_non_admin()
    {
        $item = HerdEntryReason::query()->first();
        Animal::factory()->create(['herd_entry_reason_id' => $item->id]);

        $response = $this->actingAs($this->user)->deleteJson(route('api.herd-entry-reasons.destroy', $item));
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'data' => null,
        ]);

        $this->assertDatabaseHas('herd_entry_reasons', ['id' => $item->id]);
    }
}
