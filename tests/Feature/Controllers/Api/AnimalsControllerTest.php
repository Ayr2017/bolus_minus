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

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->artisan('db:seed --class=AnimalsSeeder');
    }

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
            'name' => 'Buddy',
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
                'name',
                'number',
                'birthday',
                'organisation_id',
            ],
        ]);

        $this->assertDatabaseHas('animals', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Buddy',
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
            'is_active' => 1,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.animals.store'), $data);

        $response->assertForbidden();
    }

    public function test_show_for_admin()
    {
        $animalGroup = Animal::query()->first();

        $response = $this->actingAs($this->admin)->json('GET', route('api.animals.show', $animalGroup), ['animal_group' => $animalGroup->id]);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'animal'=>[
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
                'animal'=>[
                    'id' => $animalGroup->id,
                    'uuid' => $animalGroup->uuid,
                    'name' => $animalGroup->name,
                    'number' => $animalGroup->number,
                    'organisation_id' => $animalGroup->organisation_id,
                    'breed_id' => $animalGroup->breed_id,
                    'number_rshn' => $animalGroup->number_rshn,
                    'bolus_id' => $animalGroup->bolus_id,
                    'number_rf' => $animalGroup->number_rf,
                    'number_tavro' => $animalGroup->number_tavro,
                    'number_tag' => $animalGroup->number_tag,
                    'tag_color' => $animalGroup->tag_color,
                    'number_collar' => $animalGroup->number_collar,
                    'status_id' => $animalGroup->status_id,
                    'sex' => $animalGroup->sex,
                    'withdrawn_at' => $animalGroup->withdrawn_at,
                    'is_active' => $animalGroup->is_active,
                    'created_at' => $animalGroup->created_at,
                    'updated_at' => $animalGroup->updated_at,
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $animalGroup = Animal::query()->first();

        $response = $this->actingAs($this->user)->json('GET', route('api.animals.show', $animalGroup), ['animal_group' => 1]);

        $response->assertOk();

        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'animal'=>[
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
                'animal'=>[
                    'id' => $animalGroup->id,
                    'uuid' => $animalGroup->uuid,
                    'name' => $animalGroup->name,
                    'number' => $animalGroup->number,
                    'organisation_id' => $animalGroup->organisation_id,
                    'breed_id' => $animalGroup->breed_id,
                    'number_rshn' => $animalGroup->number_rshn,
                    'bolus_id' => $animalGroup->bolus_id,
                    'number_rf' => $animalGroup->number_rf,
                    'number_tavro' => $animalGroup->number_tavro,
                    'number_tag' => $animalGroup->number_tag,
                    'tag_color' => $animalGroup->tag_color,
                    'number_collar' => $animalGroup->number_collar,
                    'status_id' => $animalGroup->status_id,
                    'sex' => $animalGroup->sex,
                    'withdrawn_at' => $animalGroup->withdrawn_at,
                    'is_active' => $animalGroup->is_active,
                    'created_at' => $animalGroup->created_at,
                    'updated_at' => $animalGroup->updated_at,
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $animalGroup = Animal::query()->first();

        $data = [
            'name' => 'Lili',
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
            'is_active' => 0,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.animals.update', $animalGroup->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'number',
                'organisation_id',
            ],
        ]);

        $this->assertDatabaseHas('animals', $data);
    }

    public function test_update_for_non_admin()
    {
        $animalGroup = Animal::query()->first();

        $data = [
            'name' => 'Lili',
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
            'is_active' => 0,
        ];


        $response = $this->actingAs($this->user)->putJson(route('api.animals.update', $animalGroup->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'number',
                'organisation_id',
            ],
        ]);

        $this->assertDatabaseHas('animals', $data);
    }

    public function test_destroy_for_admin()
    {
        $animalGroup = AnimalGroup::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.animals.destroy', $animalGroup->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('animals', ['id' => $animalGroup->id]);
    }

    public function test_destroy_forbidden_for_non_admin()
    {
        $animalGroup = AnimalGroup::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.animals.destroy', $animalGroup->id));
        $response->assertForbidden();

        $this->assertDatabaseHas('animals', ['id' => $animalGroup->id]);
    }
}
