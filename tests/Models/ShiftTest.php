<?php

namespace Feature\Models;

use AllowDynamicProperties;
use App\Models\Shift;
use App\Models\Organisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;


#[AllowDynamicProperties] class ShiftTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_matches_table_columns()
    {
        $tableColumns = Schema::getColumnListing('shifts');
        $fillable = (new Shift())->getFillable();

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
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
            'is_active' => true,
        ];

        $item = Shift::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $item->$key);
        }
    }

    public function test_create()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        Shift::create($data);

        $this->assertDatabaseHas('shifts', $data);
    }

    public function test_read()
    {
        $item = Shift::create([
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ]);

        $foundItem = Shift::find($item->id);

        $this->assertEquals('Test Name', $foundItem->name);
        $this->assertEquals(1, $foundItem->organization_id);
        $this->assertEquals(1, $foundItem->department_id);
        $this->assertEquals('09:00', $foundItem->start_time);
        $this->assertEquals('18:00', $foundItem->end_time);
    }

    public function test_update()
    {
        $item = Shift::create([
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
            'is_active' => true
        ]);

        $item->update([
            'name' => 'Updated Name',
            'organization_id' => 2,
            'department_id' => 2,
            'start_time' => '11:11',
            'end_time' => '22:22',
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('shifts', [
            'name' => 'Updated Name',
            'organization_id' => 2,
            'department_id' => 2,
            'start_time' => '11:11',
            'end_time' => '22:22',
            'is_active' => false,
        ]);
    }

    public function test_delete()
    {
        $item = Shift::create([
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ]);

        $item->delete();

        $this->assertDatabaseMissing('shifts', [
            'id' => $item->id,
        ]);
    }

    public function test_name_is_not_unique()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        Shift::create($data);

        $item = Shift::create($data);

        $this->assertDatabaseHas('shifts', [
            'id' => $item->id,
        ]);
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => null,
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        Shift::create($data);
    }

    public function test_is_active_default_is_true()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ];

        $item = Shift::create($data);

        $item->refresh();

        $this->assertTrue($item->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => '18:00',
            'is_active' => 1,
        ];

        $item = Shift::create($data);

        $this->assertTrue($item->is_active);
    }

    public function test_start_time_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => null,
            'end_time' => '18:00',
        ];

        Shift::create($data);
    }

    public function test_end_time_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '09:00',
            'end_time' => null,
        ];

        Shift::create($data);
    }

    public function test_start_time_is_time()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '10:00',
            'end_time' => '18:00',
        ];

        $item = Shift::create($data);
        [$hours, $minutes] = explode(':', $item->start_time);
        $this->assertMatchesRegularExpression('/^\d{2}:\d{2}$/', $item->start_time);

        $this->assertGreaterThanOrEqual(0, (int) $hours);
        $this->assertLessThanOrEqual(23, (int) $hours);

        $this->assertGreaterThanOrEqual(0, (int) $minutes);
        $this->assertLessThanOrEqual(59, (int) $minutes);
    }

    public function test_end_time_is_time()
    {
        $data = [
            'name' => 'Test Name',
            'organization_id' => 1,
            'department_id' => 1,
            'start_time' => '10:00',
            'end_time' => '18:00',
        ];

        $item = Shift::create($data);
        [$hours, $minutes] = explode(':', $item->start_time);
        $this->assertMatchesRegularExpression('/^\d{2}:\d{2}$/', $item->start_time);

        $this->assertGreaterThanOrEqual(0, (int) $hours);
        $this->assertLessThanOrEqual(23, (int) $hours);

        $this->assertGreaterThanOrEqual(0, (int) $minutes);
        $this->assertLessThanOrEqual(59, (int) $minutes);
    }

    public function test_factory()
    {
        $organization = Organisation::factory()->create();
        $department = Organisation::factory()->create();
        $item = Shift::factory()->create(
            [
                'organization_id' => $organization->id,
                'department_id' => $department->id,
            ]
        );

        $this->assertDatabaseHas('shifts', [
            'id' => $item->id,
        ]);

        $this->assertNotNull($item->name);
    }

    public function test_shift_belongs_to_organization()
    {
        $organization = Organisation::factory()->create();
        $department = Organisation::factory()->create();
        $shift = Shift::factory()->create(
            [
                'organization_id' => $organization->id,
                'department_id' => $department->id,
            ]
        );

        $this->assertInstanceOf(Organisation::class, $shift->organization);
        $this->assertInstanceOf(Organisation::class, $shift->department);

        $this->assertEquals($organization->id, $shift->organization->id);
        $this->assertEquals($department->id, $shift->department->id);
    }
}
