<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\BreedingBull;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class BreedingBullControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --class=BreedingBullSeeder');
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.breeding-bulls.index'));
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'type',
                        'semen_supplier',
                        'nickname',
                        'date_of_birth',
                        'country_of_birth',
                        'tag_number',
                        'semen_code',
                        'rshn_id',
                        'breed_id',
                        'is_selected',
                        'is_active',
                        'is_own',
                        'coat_color_id',
                        'created_at',
                        'updated_at',
                        'breed' => [
                            'id',
                            'uuid',
                            'name',
                            'type',
                            'is_active',
                            'created_at',
                            'updated_at',
                        ],
                        'coat_color' => [
                            'id',
                            'name',
                            'description',
                            'is_active',
                            'created_at',
                            'updated_at',
                        ],
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
        $response = $this->actingAs($this->user)->getJson(route('api.breeding-bulls.index'));
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'type',
                        'semen_supplier',
                        'nickname',
                        'date_of_birth',
                        'country_of_birth',
                        'tag_number',
                        'semen_code',
                        'rshn_id',
                        'breed_id',
                        'is_selected',
                        'is_active',
                        'is_own',
                        'coat_color_id',
                        'created_at',
                        'updated_at',
                        'breed' => [
                            'id',
                            'uuid',
                            'name',
                            'type',
                            'is_active',
                            'created_at',
                            'updated_at',
                        ],
                        'coat_color' => [
                            'id',
                            'name',
                            'description',
                            'is_active',
                            'created_at',
                            'updated_at',
                        ],
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
            'type' => 'Test Type',
            'nickname' => 'Test Nickname',
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.breeding-bulls.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'type',
                'semen_supplier',
                'nickname',
                'date_of_birth',
                'country_of_birth',
                'tag_number',
                'semen_code',
                'rshn_id',
                'breed_id',
                'is_selected',
                'is_active',
                'is_own',
                'coat_color_id',
                'created_at',
                'updated_at',
                'breed',
                'coat_color',
            ],
        ]);

        $this->assertDatabaseHas('breeding_bulls', $data);
    }

    public function test_store_forbidden_for_non_admin()
    {
        $data = [
            'type' => 'Test Type',
            'nickname' => 'Test Nickname',
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.breeding-bulls.store'), $data);
        $response->assertForbidden();
        $this->assertDatabaseMissing('breeding_bulls', $data);
    }

    public function test_show_for_admin()
    {
        $item = BreedingBull::query()->first();

        $response = $this->actingAs($this->admin)->json('GET', route('api.breeding-bulls.show', $item), ['breeding_bull' => $item->id]);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'error',
            'success',
            'data' => [
                'id',
                'type',
                'semen_supplier',
                'nickname',
                'date_of_birth',
                'country_of_birth',
                'tag_number',
                'semen_code',
                'rshn_id',
                'breed_id',
                'is_selected',
                'is_active',
                'is_own',
                'coat_color_id',
                'created_at',
                'updated_at',
                'breed' => [
                    'id',
                    'uuid',
                    'name',
                    'type',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'coat_color' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $response->assertJson(
            [
                'message' => 'Success',
                'success' => true,
                'error' => null,
                'data' => [
                    'id' => $item->id,
                    'type' => $item->type,
                    'semen_supplier' => $item->semen_supplier,
                    'nickname' => $item->nickname,
                    'date_of_birth' => $item->date_of_birth->format('Y-m-d'),
                    'country_of_birth' => $item->country_of_birth,
                    'tag_number' => $item->tag_number,
                    'semen_code' => $item->semen_code,
                    'rshn_id' => $item->rshn_id,
                    'breed_id' => $item->breed_id,
                    'is_selected' => $item->is_selected,
                    'is_active' => $item->is_active,
                    'is_own' => $item->is_own,
                    'coat_color_id' => $item->coat_color_id,
                    'created_at' => $item->created_at->toDateTimeString(),
                    'updated_at' => $item->updated_at->toDateTimeString(),
                    'breed' => $item->breed->toArray(),
                    'coat_color' => $item->coatColor->toArray(),
                ],
            ]
        );
    }

    public function test_show_forbidden_for_non_admin()
    {
        $item = BreedingBull::query()->first();

        $response = $this->actingAs($this->user)->json('GET', route('api.breeding-bulls.show', $item), ['breeding_bull' => $item->id]);
        $response->assertForbidden();
    }

    public function test_update_for_admin()
    {
        $data = [
            'type' => 'Test Type',
            'semen_supplier' => 'Test Semen Supplier',
            'nickname' => 'Test Nickname',
            'date_of_birth' => '2020-01-01 00:00:00',
            'country_of_birth' => 'Test Country',
            'tag_number' => 'Test Tag',
            'semen_code' => 'Test Semen Code',
            'rshn_id' => 'Test RSHN',
            // 'color' => 'Test Color',
            'breed_id' => 1,
            'is_selected' => true,
            'is_active' => true,
            'is_own' => true,
            'coat_color_id' => 1,
        ];

        $item = BreedingBull::create($data);

        $updatedData = [
            'type' => 'Updated Test Type',
            'semen_supplier' => 'Updated Test Semen Supplier',
            'nickname' => 'Updated Test Nickname',
            'date_of_birth' => '2022-02-02 00:00:00',
            'country_of_birth' => 'Updated Test Country',
            'tag_number' => 'Updated Test Tag',
            'semen_code' => 'Updated Test Semen Code',
            'rshn_id' => 'Updated Test RSHN',
            // 'color' => 'Updated Test Color',
            'breed_id' => 2,
            'is_selected' => false,
            'is_active' => false,
            'is_own' => false,
            'coat_color_id' => 2,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.breeding-bulls.update', $item), $updatedData);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'type',
                'semen_supplier',
                'nickname',
                'date_of_birth',
                'country_of_birth',
                'tag_number',
                'semen_code',
                'rshn_id',
                'breed_id',
                'is_selected',
                'is_active',
                'is_own',
                'coat_color_id',
                'created_at',
                'updated_at',
                'breed' => [
                    'id',
                    'uuid',
                    'name',
                    'type',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'coat_color' => [
                    'id',
                    'name',
                    'description',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->assertDatabaseHas('breeding_bulls', $updatedData);
    }

    public function test_update_forbidden_for_non_admin()
    {
        $data = [
            'type' => 'Test Type',
            'semen_supplier' => 'Test Semen Supplier',
            'nickname' => 'Test Nickname',
            'date_of_birth' => '2020-01-01 00:00:00',
            'country_of_birth' => 'Test Country',
            'tag_number' => 'Test Tag',
            'semen_code' => 'Test Semen Code',
            'rshn_id' => 'Test RSHN',
            // 'color' => 'Test Color',
            'breed_id' => 1,
            'is_selected' => true,
            'is_active' => true,
            'is_own' => true,
            'coat_color_id' => 1,
        ];

        $item = BreedingBull::create($data);

        $updatedData = [
            'type' => 'Updated Test Type',
            'semen_supplier' => 'Updated Test Semen Supplier',
            'nickname' => 'Updated Test Nickname',
            'date_of_birth' => '2022-02-02 00:00:00',
            'country_of_birth' => 'Updated Test Country',
            'tag_number' => 'Updated Test Tag',
            'semen_code' => 'Updated Test Semen Code',
            'rshn_id' => 'Updated Test RSHN',
            // 'color' => 'Updated Test Color',
            'breed_id' => 2,
            'is_selected' => false,
            'is_active' => false,
            'is_own' => false,
            'coat_color_id' => 2,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.breeding-bulls.update', $item), $updatedData);
        $response->assertForbidden();

        $this->assertDatabaseHas('breeding_bulls', $data);
    }

    public function test_destroy_for_admin()
    {
        $item = BreedingBull::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.breeding-bulls.destroy', $item), ['breeding_bull' => $item->id]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('breeding_bulls', ['id' => $item->id]);
    }

    public function test_destroy_forbidden_for_non_admin()
    {
        $item = BreedingBull::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.breeding-bulls.destroy', $item), ['breeding_bull' => $item->id]);

        $response->assertForbidden();

        $this->assertDatabaseHas('breeding_bulls', ['id' => $item->id]);
    }
}
