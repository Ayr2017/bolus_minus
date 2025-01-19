<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class ShiftControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->artisan('db:seed --class=OrganisationSeeder');
        $this->artisan('db:seed --class=ShiftSeeder');
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.shifts.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'name',
                        'organization',
                        'department',
                        'start_time',
                        'end_time',
                        'is_active',
                        'created_at',
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
        $response = $this->actingAs($this->user)->getJson(route('api.shifts.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'name',
                        'organization',
                        'department',
                        'start_time',
                        'end_time',
                        'is_active',
                        'created_at',
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
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.shifts.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'is_active',
                'start_time',
                'end_time',
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
                ]
            ],
        ]);

        $this->assertDatabaseHas('shifts', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.shifts.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'name',
                'is_active',
                'start_time',
                'end_time',
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
                ]
            ],
        ]);

        $this->assertDatabaseHas('shifts', $data);
    }

    public function test_show_for_admin()
    {
        $item = Shift::query()->first();

        $response = $this->actingAs($this->admin)->json('GET', route('api.shifts.show', $item));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'name',
                    'is_active',
                    'start_time',
                    'end_time',
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
                    ]
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'is_active' => $item->is_active,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'organization' => $item->organization->toArray(),
                    'department' => $item->department->toArray(),
                ]
            ]
        ]);
    }

    public function test_show_for_non_admin()
    {
        $item = Shift::query()->first();

        $response = $this->actingAs($this->user)->json('GET', route('api.shifts.show', $item));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'name',
                    'is_active',
                    'start_time',
                    'end_time',
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
                    ]
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'id' => $item->id,
                    'name' => $item->name,
                    'is_active' => $item->is_active,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'organization' => $item->organization->toArray(),
                    'department' => $item->department->toArray(),
                ]
            ]
        ]);
    }

    public function test_update_for_admin()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Shift::create($data);

        $updatedData = [
            'name' => 'Updated Test Name',
            'organization_id' => 2,
            'department_id' => 2,
            'start_time' => '11:00',
            'end_time' => '22:00',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.shifts.update', $item), $updatedData);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'name',
                    'is_active',
                    'start_time',
                    'end_time',
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
                    ]
                ]
            ],
        ]);

        $this->assertDatabaseHas('shifts', $updatedData);
    }

    public function test_update_for_non_admin()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Shift::create($data);

        $updatedData = [
            'name' => 'Updated Test Name',
            'organization_id' => 2,
            'department_id' => 2,
            'start_time' => '11:00',
            'end_time' => '22:00',
            'is_active' => false,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.shifts.update', $item), $updatedData);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'name',
                    'is_active',
                    'start_time',
                    'end_time',
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
                    ]
                ]
            ],
        ]);

        $this->assertDatabaseHas('shifts', $updatedData);
    }

    public function test_destroy_for_admin()
    {
        $item = Shift::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.shifts.destroy', $item));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('shifts', ['id' => $item->id]);
    }

    public function test_destroy_for_non_admin()
    {
        $item = Shift::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.shifts.destroy', $item->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('shifts', ['id' => $item->id]);
    }
}
