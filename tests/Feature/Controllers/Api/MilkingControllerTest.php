<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Milking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class MilkingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->artisan('db:seed --class=ShiftSeeder');
        $this->artisan('db:seed --class=OrganisationSeeder');
        Milking::factory()->count(1)->create();
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.milkings.index'));
        $response->assertOk();

        // TODO: уточнить, возвращается непагинированный результат - это ок?
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data'
        ]);
    }

    public function test_index_for_non_admin()
    {
        $response = $this->actingAs($this->user)->getJson(route('api.milkings.index'));
        $response->assertOk();

        // TODO: уточнить, возвращается непагинированный результат - это ок?
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data'
        ]);
    }

    public function test_store_for_admin()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.milkings.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'start_time',
                'end_time',
                'created_at',
                'organization' => [
                    'id',
                    'uuid',
                    'name',
                    'structural_unit_id',
                    'parent_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'department' => [
                    'id',
                    'uuid',
                    'name',
                    'structural_unit_id',
                    'parent_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'shift' => [
                    'id',
                    'name',
                    'start_time',
                    'end_time',
                    'is_active',
                    'created_at',
                    // 'updated_at', TODO: уточнить, не возвращается updated_at для shift - это ок?
                ]
            ],
        ]);

        $this->assertDatabaseHas('milkings', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.milkings.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'start_time',
                'end_time',
                'created_at',
                'organization' => [
                    'id',
                    'uuid',
                    'name',
                    'structural_unit_id',
                    'parent_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'department' => [
                    'id',
                    'uuid',
                    'name',
                    'structural_unit_id',
                    'parent_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'shift' => [
                    'id',
                    'name',
                    'start_time',
                    'end_time',
                    'is_active',
                    'created_at',
                    // 'updated_at', TODO: уточнить, не возвращается updated_at для shift - это ок?
                ]
            ],
        ]);

        $this->assertDatabaseHas('milkings', $data);
    }

    // TODO: залогиненный пользователь не может просматривать, в ShowMilkingRequest authorize сделать true
    public function test_show_for_admin()
    {
        $item = Milking::query()->first();

        $response = $this->actingAs($this->admin)->json('GET', route('api.milkings.show', $item));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'milking' => [
                    'id',
                    'start_time',
                    'end_time',
                    'created_at',
                    'organization' => [
                        'id',
                        'uuid',
                        'name',
                        'structural_unit_id',
                        'parent_id',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                    'department' => [
                        'id',
                        'uuid',
                        'name',
                        'structural_unit_id',
                        'parent_id',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                    'shift' => [
                        'id',
                        'name',
                        'start_time',
                        'end_time',
                        'is_active',
                        'created_at',
                        // 'updated_at', TODO: уточнить, не возвращается updated_at для shift - это ок?
                    ]
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'milking' => [
                    'id' => $item->id,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'created_at' => $item->created_at->toDateTimeString(),
                    'organization' => $item->organization->toArray(),
                    'department' => $item->department->toArray(),
                    'shift' => [
                        // TODO: уточнить. структура shift в ответе отличается от структуры в бд (нет updated_at), при этом organization, department возвращаются как в бд
                        'id' => $item->shift->id,
                        'name' => $item->shift->name,
                        'start_time' => $item->shift->start_time,
                        'end_time' => $item->shift->end_time,
                        'is_active' => $item->shift->is_active,
                        'created_at' => $item->shift->created_at,
                    ],
                ]
            ],
        ]);
    }

    // TODO: залогиненный пользователь не может просматривать, в ShowMilkingRequest authorize сделать true
    public function test_show_for_non_admin()
    {
        $item = Milking::query()->first();

        $response = $this->actingAs($this->user)->json('GET', route('api.milkings.show', $item));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'milking' => [
                    'id',
                    'start_time',
                    'end_time',
                    'created_at',
                    'organization' => [
                        'id',
                        'uuid',
                        'name',
                        'structural_unit_id',
                        'parent_id',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                    'department' => [
                        'id',
                        'uuid',
                        'name',
                        'structural_unit_id',
                        'parent_id',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                    'shift' => [
                        'id',
                        'name',
                        'start_time',
                        'end_time',
                        'is_active',
                        'created_at',
                        // 'updated_at', TODO: уточнить, не возвращается updated_at для shift - это ок?
                    ]
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                'milking' => [
                    'id' => $item->id,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'created_at' => $item->created_at->toDateTimeString(),
                    'organization' => $item->organization->toArray(),
                    'department' => $item->department->toArray(),
                    'shift' => [
                        // TODO: уточнить. структура shift в ответе отличается от структуры в бд (нет updated_at), при этом organization, department возвращаются как в бд
                        'id' => $item->shift->id,
                        'name' => $item->shift->name,
                        'start_time' => $item->shift->start_time,
                        'end_time' => $item->shift->end_time,
                        'is_active' => $item->shift->is_active,
                        'created_at' => $item->shift->created_at,
                    ],
                ]
            ],
        ]);
    }

    public function test_update_for_admin()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);

        $updatedData = [
            'organization_id' => 2,
            'department_id' => 2,
            'shift_id' => 2,
            'start_time' => '11:11',
            'end_time' => '22:22',
            'is_active' => false
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.milkings.update', $item), $updatedData);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'milking' => [
                    'id',
                    'start_time',
                    'end_time',
                    'created_at',
                ]
            ],
        ]);

        // TODO: данные в бд не обновляются, проверить rules в UpdateMilkingRequest
        $this->assertDatabaseHas('milkings', $updatedData);
    }

    public function test_update_for_non_admin()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);

        $updatedData = [
            'organization_id' => 2,
            'department_id' => 2,
            'shift_id' => 2,
            'start_time' => '11:11',
            'end_time' => '22:22',
            'is_active' => false
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.milkings.update', $item), $updatedData);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'milking' => [
                    'id',
                    'start_time',
                    'end_time',
                    'created_at',
                ]
            ],
        ]);

        // TODO: данные в бд не обновляются, проверить rules в UpdateMilkingRequest
        $this->assertDatabaseHas('milkings', $updatedData);
    }

    // // TODO: залогиненный пользователь не может удалять, в DeleteMilkingRequest authorize сделать true
    public function test_destroy_for_admin()
    {
        $item = Milking::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.milkings.destroy', $item));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('milkings', ['id' => $item->id]);
    }

    // // TODO: залогиненный пользователь не может удалять, в DeleteMilkingRequest authorize сделать true
    public function test_destroy_for_non_admin()
    {
        $item = Milking::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.milkings.destroy', $item->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('milkings', ['id' => $item->id]);
    }
}
