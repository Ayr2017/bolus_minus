<?php

namespace Feature\Models;

use AllowDynamicProperties;
use App\Models\Milking;
use App\Models\Organisation;
use App\Models\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;

#[AllowDynamicProperties] class MilkingTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_matches_table_columns()
    {
        $tableColumns = Schema::getColumnListing('milkings');
        $fillable = (new Milking())->getFillable();

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
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $item->$key);
        }
    }

    public function test_create()
    {
        $data = [
            'is_active' => true,
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        Milking::create($data);

        $this->assertDatabaseHas('milkings', $data);
    }

    public function test_read()
    {
        $data = [
            'is_active' => true,
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);
        $foundItem = Milking::find($item->id);

        $this->assertEquals(1, $foundItem->organization_id);
        $this->assertEquals(1, $foundItem->department_id);
        $this->assertEquals(1, $foundItem->shift_id);
        $this->assertEquals('09:00', $foundItem->start_time);
        $this->assertEquals('18:00', $foundItem->end_time);
    }

    public function test_update()
    {
        $data = [
            'is_active' => true,
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);

        $updatedData = [
            'is_active' => false,
            'organization_id' => 2,
            'department_id' => 2,
            'shift_id' => 2,
            'start_time' => '11:11',
            'end_time' => '22:22',
        ];

        $item->update($updatedData);

        $this->assertDatabaseHas('milkings', $updatedData);
    }

    public function test_delete()
    {
        $data = [
            'is_active' => true,
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);

        $item->delete();

        $this->assertDatabaseMissing('milkings', [
            'id' => $item->id,
        ]);
    }

    public function test_is_active_default_is_true()
    {
        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);

        $item->refresh();

        $this->assertTrue($item->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $data = [
            'is_active' => 1,
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);

        $this->assertTrue($item->is_active);
    }

    public function test_start_time_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'end_time' => '18:00',
        ];

        Milking::create($data);
    }

    public function test_start_time_is_not_null()
    {
        $this->expectException(QueryException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'end_time' => '18:00',
            'start_time' => null,
        ];

        Milking::create($data);
    }

    public function test_end_time_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
        ];

        Milking::create($data);
    }

    public function test_end_time_is_not_null()
    {
        $this->expectException(QueryException::class);

        $data = [
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => null,
        ];

        Milking::create($data);
    }

    public function test_start_time_is_time()
    {
        $data = [
            'is_active' => 1,
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Milking::create($data);
        [$hours, $minutes] = explode(':', $item->start_time);
        $this->assertMatchesRegularExpression('/^\d{1,2}:\d{2}$/', $item->start_time);

        $this->assertGreaterThanOrEqual(0, (int) $hours);
        $this->assertLessThanOrEqual(23, (int) $hours);

        $this->assertGreaterThanOrEqual(0, (int) $minutes);
        $this->assertLessThanOrEqual(59, (int) $minutes);
    }

    public function test_end_time_is_time()
    {
        $data = [
            'is_active' => 1,
            'organization_id' => 1,
            'department_id' => 1,
            'shift_id' => 1,
            'start_time' => '09:00',
            'end_time' => '08:00',
        ];

        $item = Milking::create($data);
        [$hours, $minutes] = explode(':', $item->end_time);
        $this->assertMatchesRegularExpression('/^\d{1,2}:\d{2}$/', $item->end_time);

        $this->assertGreaterThanOrEqual(0, (int) $hours);
        $this->assertLessThanOrEqual(23, (int) $hours);

        $this->assertGreaterThanOrEqual(0, (int) $minutes);
        $this->assertLessThanOrEqual(59, (int) $minutes);
    }

    public function test_factory()
    {
        $organization = Organisation::factory()->create();
        $department = Organisation::factory()->create();
        $shift = Shift::factory()->create();
        $item = Milking::factory()->create(
            [
                'organization_id' => $organization->id,
                'department_id' => $department->id,
                'shift_id' => $shift->id,
                'start_time' => '09:00',
                'end_time' => '18:00',
            ]
        );

        $this->assertDatabaseHas('milkings', [
            'id' => $item->id,
        ]);
    }

    public function test_milking_organization_is_organization()
    {
        $organization = Organisation::factory()->create();
        $department = Organisation::factory()->create();
        $shift = Shift::factory()->create();

        $item = Milking::create(
            [
                'organization_id' => $organization->id,
                'department_id' => $department->id,
                'shift_id' => $shift->id,
                'start_time' => '09:00',
                'end_time' => '18:00',
            ]
        );

        $this->assertInstanceOf(Organisation::class, $item->organization);
        $this->assertEquals($organization->id, $item->organization->id);
    }

    public function test_milking_department_is_organization()
    {
        $organization = Organisation::factory()->create();
        $department = Organisation::factory()->create();
        $shift = Shift::factory()->create();

        $item = Milking::create(
            [
                'organization_id' => $organization->id,
                'department_id' => $department->id,
                'shift_id' => $shift->id,
                'start_time' => '09:00',
                'end_time' => '18:00',
            ]
        );

        $this->assertInstanceOf(Organisation::class, $item->department);
        $this->assertEquals($department->id, $item->department->id);
    }
}
