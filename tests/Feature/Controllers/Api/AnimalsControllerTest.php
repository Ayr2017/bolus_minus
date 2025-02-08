<?php

namespace Controllers\Api;

use AllowDynamicProperties;
use App\Models\Animal;
use App\Models\AnimalGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

#[AllowDynamicProperties] class AnimalsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.animals.index'));
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
        $response = $this->actingAs($this->user)->getJson(route('api.animals.index'));
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
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2020-01-01 00:00:00',
            'breed_id' => 1,
            'number_rshn' => 'Test Number RSHN',
            'bolus_id' => 1,
            'number_rf' => 'Test Number RF',
            'number_tavro' => 'Test Number Tavro',
            'number_tag' => 'Test Number Tag',
            'tag_color' => 'Test Tag Color',
            'number_collar' => 'Test Number Collar',
            'status_id' => 1,
            'sex' => 'male',
            'withdrawn_at' => '2020-01-01 00:00:00',
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.animals.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'uuid',
                'name',
                'number',
                'organisation_id',
                'birthday',
                'breed_id',
                'number_rshn',
                'bolus_id',
                'number_rf',
                'number_tavro',
                'number_tag',
                'tag_color',
                'number_collar',
                'status_id',
                'sex',
                'withdrawn_at',
                'is_active',
                'created_at',
                'updated_at',
            ],
        ]);

        $this->assertDatabaseHas('animals', $data);
    }

    public function test_store_forbidden_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'number' => '1234',
            'organisation_id' => 1,
            'birthday' => '2020-01-01 00:00:00',
            'breed_id' => 1,
            'number_rshn' => '5678',
            'bolus_id' => 1,
            'number_rf' => '91011',
            'number_tavro' => '121314',
            'number_tag' => '151617',
            'tag_color' => 'red',
            'number_collar' => '181920',
            'status_id' => 1,
            'sex' => 'male',
            'withdrawn_at' => '2020-01-01 00:00:00',
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.animals.store'), $data);
        $response->assertForbidden();
        $this->assertDatabaseMissing('animals', $data);
    }

    public function test_show_for_admin()
    {
        $item = Animal::query()->first();

        $response = $this->actingAs($this->admin)->json('GET', route('api.animals.show', $item), ['animal' => $item->id]);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'animal' => [
                    'id',
                    'uuid',
                    'name',
                    'number',
                    'organisation_id',
                    'breed_id',
                    'number_rshn',
                    'bolus_id',
                    'number_rf',
                    'number_tavro',
                    'number_tag',
                    'tag_color',
                    'number_collar',
                    'status_id',
                    'sex',
                    'withdrawn_at',
                    'is_active',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'animal' => [
                    'id' => $item->id,
                    'uuid' => $item->uuid,
                    'name' => $item->name,
                    'number' => $item->number,
                    'organisation_id' => $item->organisation_id,
                    'breed_id' => $item->breed_id,
                    'number_rshn' => $item->number_rshn,
                    'bolus_id' => $item->bolus_id,
                    'number_rf' => $item->number_rf,
                    'number_tavro' => $item->number_tavro,
                    'number_tag' => $item->number_tag,
                    'tag_color' => $item->tag_color,
                    'number_collar' => $item->number_collar,
                    'status_id' => $item->status_id,
                    'sex' => $item->sex,
                    'withdrawn_at' => $item->withdrawn_at,
                    'is_active' => $item->is_active,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $item = Animal::query()->first();

        $response = $this->actingAs($this->user)->json('GET', route('api.animals.show', $item), ['animal' => $item->id]);

        $response->assertOk();

        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'animal' => [
                    'id',
                    'uuid',
                    'name',
                    'number',
                    'organisation_id',
                    'breed_id',
                    'number_rshn',
                    'bolus_id',
                    'number_rf',
                    'number_tavro',
                    'number_tag',
                    'tag_color',
                    'number_collar',
                    'status_id',
                    'sex',
                    'withdrawn_at',
                    'is_active',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'animal' => [
                    'id' => $item->id,
                    'uuid' => $item->uuid,
                    'name' => $item->name,
                    'number' => $item->number,
                    'organisation_id' => $item->organisation_id,
                    'breed_id' => $item->breed_id,
                    'number_rshn' => $item->number_rshn,
                    'bolus_id' => $item->bolus_id,
                    'number_rf' => $item->number_rf,
                    'number_tavro' => $item->number_tavro,
                    'number_tag' => $item->number_tag,
                    'tag_color' => $item->tag_color,
                    'number_collar' => $item->number_collar,
                    'status_id' => $item->status_id,
                    'sex' => $item->sex,
                    'withdrawn_at' => $item->withdrawn_at,
                    'is_active' => $item->is_active,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $item = Animal::query()->first();

        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2020-01-01 00:00:00',
            'breed_id' => 1,
            'number_rshn' => 'Test Number RSHN',
            'bolus_id' => 1,
            'number_rf' => 'Test Number RF',
            'number_tavro' => 'Test Number Tavro',
            'number_tag' => 'Test Number Tag',
            'tag_color' => 'Test Tag Color',
            'number_collar' => 'Test Number Collar',
            'status_id' => 1,
            'sex' => 'male',
            'withdrawn_at' => '2020-01-01 00:00:00',
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.animals.update', $item->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'uuid',
                'name',
                'number',
                'organisation_id',
                'breed_id',
                'number_rshn',
                'bolus_id',
                'number_rf',
                'number_tavro',
                'number_tag',
                'tag_color',
                'number_collar',
                'status_id',
                'sex',
                'withdrawn_at',
                'is_active',
            ],
        ]);

        $this->assertDatabaseHas('animals', $data);
    }

    public function test_update_for_non_admin()
    {
        $item = Animal::query()->first();

        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2020-01-01 00:00:00',
            'breed_id' => 1,
            'number_rshn' => 'Test Number RSHN',
            'bolus_id' => 1,
            'number_rf' => 'Test Number RF',
            'number_tavro' => 'Test Number Tavro',
            'number_tag' => 'Test Number Tag',
            'tag_color' => 'Test Tag Color',
            'number_collar' => 'Test Number Collar',
            'status_id' => 1,
            'sex' => 'male',
            'withdrawn_at' => '2020-01-01 00:00:00',
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.animals.update', $item->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'uuid',
                'name',
                'number',
                'organisation_id',
                'breed_id',
                'number_rshn',
                'bolus_id',
                'number_rf',
                'number_tavro',
                'number_tag',
                'tag_color',
                'number_collar',
                'status_id',
                'sex',
                'withdrawn_at',
                'is_active',
            ],
        ]);

        $this->assertDatabaseHas('animals', $data);
    }

    public function test_destroy_soft_for_admin()
    {
        $item = Animal::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.animals.destroy', $item->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertSoftDeleted('animals', ['id' => $item->id]);
    }

    public function test_destroy_soft_forbidden_for_non_admin()
    {
        $item = Animal::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.animals.destroy', $item->id));
        $response->assertForbidden();

        $this->assertDatabaseHas('animals', ['id' => $item->id, 'deleted_at' => null]);
    }
}
