<?php

namespace Tests\Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\MilkingEquipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Enums\EquipmentType;
use App\Models\Organisation;

#[AllowDynamicProperties] class MilkingEquipmentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->artisan('db:seed --class=OrganisationSeeder');
        MilkingEquipment::factory()->count(1)->create();
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.milking-equipments.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'organization',
                        'department',
                        'equipment_type',
                        'milking_places_amount',
                        'milking_per_day_amount',
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
        $response = $this->actingAs($this->user)->getJson(route('api.milking-equipments.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'organization',
                        'department',
                        'equipment_type',
                        'milking_places_amount',
                        'milking_per_day_amount',
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
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
            'milking_per_day_amount' => 1,
        ];

        $response = $this->actingAs($this->admin)->postJson(route('api.milking-equipments.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'equipment_type',
                'created_at',
                'milking_places_amount',
                'milking_per_day_amount',
                'organization' => [
                    'id',
                    'uuid',
                    'name',
                    'parent_id',
                    'structural_unit_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'department' => [
                    'id',
                    'uuid',
                    'name',
                    'parent_id',
                    'structural_unit_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->assertDatabaseHas('milking_equipments', $data);
    }

    public function test_store_for_non_admin()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
            'milking_per_day_amount' => 1,
        ];

        $response = $this->actingAs($this->user)->postJson(route('api.milking-equipments.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'id',
                'equipment_type',
                'created_at',
                'milking_places_amount',
                'milking_per_day_amount',
                'organization' => [
                    'id',
                    'uuid',
                    'name',
                    'parent_id',
                    'structural_unit_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
                'department' => [
                    'id',
                    'uuid',
                    'name',
                    'parent_id',
                    'structural_unit_id',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->assertDatabaseHas('milking_equipments', $data);
    }

    public function test_show_for_admin()
    {
        $item = MilkingEquipment::query()->first();

        $response = $this->actingAs($this->admin)->json('GET', route('api.milking-equipments.show', $item));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'equipment_type',
                    'milking_places_amount',
                    'milking_per_day_amount',
                    'created_at',
                    'organization' => [
                        'id',
                        'uuid',
                        'name',
                        'parent_id',
                        'structural_unit_id',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                    'department' => [
                        'id',
                        'uuid',
                        'name',
                        'parent_id',
                        'structural_unit_id',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'id' => $item->id,
                    'organization' => $item->organization->toArray(),
                    'department' => $item->department->toArray(),
                    'equipment_type' => $item->equipment_type,
                    'milking_places_amount' => $item->milking_places_amount,
                    'milking_per_day_amount' => $item->milking_per_day_amount,
                    'created_at' => $item->created_at->toDateTimeString(),
                ]
            ],
        ]);
    }

    public function test_show_for_non_admin()
    {
        $item = MilkingEquipment::query()->first();

        $response = $this->actingAs($this->user)->json('GET', route('api.milking-equipments.show', $item));

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'equipment_type',
                    'milking_places_amount',
                    'milking_per_day_amount',
                    'created_at',
                    'organization' => [
                        'id',
                        'uuid',
                        'name',
                        'parent_id',
                        'structural_unit_id',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                    'department' => [
                        'id',
                        'uuid',
                        'name',
                        'parent_id',
                        'structural_unit_id',
                        'is_active',
                        'created_at',
                        'updated_at',
                    ],
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'id' => $item->id,
                    'organization' => $item->organization->toArray(),
                    'department' => $item->department->toArray(),
                    'equipment_type' => $item->equipment_type,
                    'milking_places_amount' => $item->milking_places_amount,
                    'milking_per_day_amount' => $item->milking_per_day_amount,
                    'created_at' => $item->created_at->toDateTimeString(),
                ]
            ],
        ]);
    }

    public function test_update_for_admin()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
            'milking_per_day_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);

        $updatedData = [
            'organization_id' => 2,
            'department_id' => 2,
            'equipment_type' => EquipmentType::HERRINGBONE->value,
            'milking_places_amount' => 2,
            'milking_per_day_amount' => 2,
        ];

        $response = $this->actingAs($this->admin)->putJson(route('api.milking-equipments.update', $item), $updatedData);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'organization',
                    'department',
                    'equipment_type',
                    'milking_places_amount',
                    'milking_per_day_amount',
                    'created_at',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'id' => $item->id,
                    'organization' => Organisation::find($updatedData['organization_id'])->toArray(),
                    'department' => Organisation::find($updatedData['department_id'])->toArray(),
                    'equipment_type' => $updatedData['equipment_type'],
                    'milking_places_amount' => $updatedData['milking_places_amount'],
                    'milking_per_day_amount' => $updatedData['milking_per_day_amount'],
                    'created_at' => $item->created_at->toDateTimeString(),
                ]
            ],
        ]);

        $this->assertDatabaseHas('milking_equipments', $updatedData);
    }

    public function test_update_for_non_admin()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
            'milking_per_day_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);

        $updatedData = [
            'organization_id' => 2,
            'department_id' => 2,
            'equipment_type' => EquipmentType::HERRINGBONE->value,
            'milking_places_amount' => 2,
            'milking_per_day_amount' => 2,
        ];

        $response = $this->actingAs($this->user)->putJson(route('api.milking-equipments.update', $item), $updatedData);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                [
                    'id',
                    'organization',
                    'department',
                    'equipment_type',
                    'milking_places_amount',
                    'milking_per_day_amount',
                    'created_at',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'id' => $item->id,
                    'organization' => Organisation::find($updatedData['organization_id'])->toArray(),
                    'department' => Organisation::find($updatedData['department_id'])->toArray(),
                    'equipment_type' => $updatedData['equipment_type'],
                    'milking_places_amount' => $updatedData['milking_places_amount'],
                    'milking_per_day_amount' => $updatedData['milking_per_day_amount'],
                    'created_at' => $item->created_at->toDateTimeString(),
                ]
            ],
        ]);

        $this->assertDatabaseHas('milking_equipments', $updatedData);
    }

    public function test_destroy_for_admin()
    {
        $item = MilkingEquipment::query()->first();

        $response = $this->actingAs($this->admin)->deleteJson(route('api.milking-equipments.destroy', $item));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('milking_equipments', ['id' => $item->id]);
    }

    public function test_destroy_for_non_admin()
    {
        $item = MilkingEquipment::query()->first();

        $response = $this->actingAs($this->user)->deleteJson(route('api.milking-equipments.destroy', $item->id));

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'error' => null,
        ]);

        $this->assertDatabaseMissing('milking_equipments', ['id' => $item->id]);
    }
}
