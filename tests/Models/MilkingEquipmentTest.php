<?php

namespace Tests\Models;

use AllowDynamicProperties;
use App\Models\MilkingEquipment;
use App\Models\Organisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;
use App\Enums\EquipmentType;
use Illuminate\Validation\ValidationException;




#[AllowDynamicProperties] class MilkingEquipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_matches_table_columns()
    {
        $tableColumns = Schema::getColumnListing('milking_equipments');
        $fillable = (new MilkingEquipment())->getFillable();

        foreach ($fillable as $field) {
            $this->assertContains($field, $tableColumns, "Поле '$field' указано в fillable, но отсутствует в таблице.");
        }

        foreach ($tableColumns as $column) {
            if ($column !== 'id' && $column !== 'created_at' && $column !== 'updated_at') {
                $this->assertContains($column, $fillable, "Колонка '$column' есть в таблице, но отсутствует в fillable.");
            }
        }
    }

    public function test_mass_assignment()
    {
        $data = [
            'is_active' => true,
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
            'milking_per_day_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $item->$key);
        }
    }

    public function test_create()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
        ];

        MilkingEquipment::create($data);

        $this->assertDatabaseHas('milking_equipments', $data);
    }

    public function test_read()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);
        $foundItem = MilkingEquipment::find($item->id);

        $this->assertEquals(1, $foundItem->organization_id);
        $this->assertEquals(1, $foundItem->department_id);
        $this->assertEquals(EquipmentType::PARALLEL->value, $foundItem->equipment_type);
        $this->assertEquals(1, $foundItem->milking_places_amount);
    }

    public function test_update()
    {
        $data = [
            'is_active' => true,
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
            'milking_per_day_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);

        $updatedData = [
            'is_active' => false,
            'organization_id' => 2,
            'department_id' => 2,
            'equipment_type' => EquipmentType::HERRINGBONE->value,
            'milking_places_amount' => 2,
            'milking_per_day_amount' => 2,
        ];

        $item->update($updatedData);

        $this->assertDatabaseHas('milking_equipments', $updatedData);
    }

    public function test_delete()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);

        $item->delete();

        $this->assertDatabaseMissing('milking_equipments', [
            'id' => $item->id,
        ]);
    }

    public function test_is_active_default_is_true()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);

        $item->refresh();

        $this->assertTrue($item->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $data = [
            'is_active' => 1,
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);

        $this->assertTrue($item->is_active);
    }

    public function test_equipment_type_is_required()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'milking_places_amount' => 1,
        ];

        MilkingEquipment::create($data);
    }

    public function test_equipment_type_is_not_null()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'milking_places_amount' => 1,
            'equipment_type' => null,
        ];

        MilkingEquipment::create($data);
    }

    public function test_milking_places_amount_is_required()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
        ];

        MilkingEquipment::create($data);
    }

    public function test_milking_places_amount_is_integer()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => 'Test Equipment Type',
            'milking_places_amount' => 'Test', // Строка вместо числа
        ];

        MilkingEquipment::create($data);
    }

    public function test_milking_per_day_amount_has_default()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);

        $item->refresh();

        $this->assertNotNull($item->milking_per_day_amount);
    }

    public function test_equipment_type_is_valid_enum()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => EquipmentType::PARALLEL->value,
            'milking_places_amount' => 1,
        ];

        $item = MilkingEquipment::create($data);
        $this->assertEquals(EquipmentType::PARALLEL->value, $item->equipment_type);
    }

    public function test_equipment_type_is_not_invalid_enum()
    {
        $this->expectException(ValidationException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'equipment_type' => 'недопустимое значение',
            'milking_places_amount' => 1,
        ];

        MilkingEquipment::create($data);
    }

    public function test_factory()
    {
        $organization = Organisation::factory()->create();
        $department = Organisation::factory()->create();
        $item = MilkingEquipment::factory()->create(
            [
                'organization_id' => $organization->id,
                'department_id' => $department->id,
                'equipment_type' => EquipmentType::PARALLEL->value,
                'milking_places_amount' => 1,
            ]
        );

        $this->assertDatabaseHas('milking_equipments', [
            'id' => $item->id,
        ]);
    }

    public function test_milking_equipment_organization_is_organization()
    {
        $organization = Organisation::factory()->create();
        $department = Organisation::factory()->create();

        $item = MilkingEquipment::create(
            [
                'organization_id' => $organization->id,
                'department_id' => $department->id,
                'equipment_type' => EquipmentType::PARALLEL->value,
                'milking_places_amount' => 1,
            ]
        );

        $this->assertInstanceOf(Organisation::class, $item->organization);
        $this->assertEquals($organization->id, $item->organization->id);
    }

    public function test_milking_equipment_department_is_organization()
    {
        $organization = Organisation::factory()->create();
        $department = Organisation::factory()->create();


        $item = MilkingEquipment::create(
            [
                'organization_id' => $organization->id,
                'department_id' => $department->id,
                'equipment_type' => EquipmentType::PARALLEL->value,
                'milking_places_amount' => 1,
            ]
        );

        $this->assertInstanceOf(Organisation::class, $item->department);
        $this->assertEquals($department->id, $item->department->id);
    }
}
