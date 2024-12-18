<?php

namespace Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\AnimalGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

#[AllowDynamicProperties] class AnimalGroupsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->artisan('db:seed --class=AnimalGroupsSeeder');
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.animal-groups.index'));
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
        $response = $this->actingAs($this->user)->getJson(route('api.animal-groups.index'));
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

        $response = $this->actingAs($this->admin)->postJson(route('api.animal-groups.store'), $data);

        // TODO: после создания отдавать 201 вместо 200
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

        $this->assertDatabaseHas('animal_groups', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.animal-groups.store'), $data);

        // TODO: после создания отдавать 201 вместо 200
        $response->assertCreated();
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

        $this->assertDatabaseHas('animal_groups', $data);
    }

    public function test_show_for_admin()
    {
        $animalGroup = AnimalGroup::query()->first();

        // TODO: если убрать prepareForValidation в ShowAnimalGroupRequest, то работает
        $response = $this->actingAs($this->admin)->json('GET', route('api.animal-groups.show', $animalGroup), ['animal_group' => $animalGroup->id]);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'breed' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'breed' => [
                    'id' => $animalGroup->id,
                    'name' => $animalGroup->name,
                    'description' => $animalGroup->description,
                    'is_active' => $animalGroup->is_active
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $animalGroup = AnimalGroup::query()->first();

        // TODO: если убрать prepareForValidation в ShowAnimalGroupRequest, то работает
        $response = $this->actingAs($this->user)->json('GET', route('api.animal-groups.show', $animalGroup), ['animal_group' => 1]);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'breed' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'breed' => [
                    'id' => $animalGroup->id,
                    'name' => $animalGroup->name,
                    'description' => $animalGroup->description,
                    'is_active' => $animalGroup->is_active
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $animalGroup = AnimalGroup::query()->first();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.animal-groups.update', $animalGroup->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'breed' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                ]
            ],
        ]);

        $this->assertDatabaseHas('animal_groups', $data);
    }

    public function test_update_for_non_admin()
    {
        $animalGroup = AnimalGroup::query()->first();

        $data = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.animal-groups.update', $animalGroup->id), $data);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'breed' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                ]
            ],
        ]);

        $this->assertDatabaseHas('animal_groups', $data);
    }

    public function test_destroy_for_admin()
    {
        $animalGroup = AnimalGroup::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.animal-groups.destroy', $animalGroup->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('animal_groups', ['id' => $animalGroup->id]);
    }

    public function test_destroy_forbidden_for_non_admin()
    {
        $animalGroup = AnimalGroup::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.animal-groups.destroy', $animalGroup->id));
        $response->assertForbidden();

        $this->assertDatabaseHas('animal_groups', ['id' => $animalGroup->id]);
    }
}
