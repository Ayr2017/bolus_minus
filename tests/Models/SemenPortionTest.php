<?php

namespace Tests\Models;

use AllowDynamicProperties;
use App\Models\SemenPortion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;


#[AllowDynamicProperties] class SemenPortionTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_matches_table_columns()
    {
        $tableColumns = Schema::getColumnListing('semen_portions');
        $fillable = (new SemenPortion())->getFillable();

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
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $result = SemenPortion::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $result->$key);
        }
    }

    public function test_create()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        SemenPortion::create($data);

        $this->assertDatabaseHas('semen_portions', $data);
    }

    public function test_read()
    {
        $result = SemenPortion::create([
            'name' => 'Test Name',
        ]);

        $found = SemenPortion::find($result->id);

        $this->assertEquals('Test Name', $found->name);
    }

    public function test_update()
    {
        $result = SemenPortion::create([
            'name' => 'Test Name',
            'description' => 'Test Description',
        ]);

        $result->update([
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);

        $this->assertDatabaseHas('semen_portions', [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);
    }

    public function test_delete()
    {
        $result = SemenPortion::create([
            'name' => 'Test Name',
        ]);

        $result->delete();

        $this->assertDatabaseMissing('semen_portions', [
            'id' => $result->id,
        ]);
    }

    public function test_name_is_unique()
    {
        SemenPortion::create(['name' => 'Test Name']);
        $this->expectException(QueryException::class);
        SemenPortion::create(['name' => 'Test Name']);
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);
        SemenPortion::create(['name' => null]);
    }

    public function test_description_is_nullable()
    {
        $result = SemenPortion::create([
            'name' => 'Test Name',
            'description' => null,
        ]);

        $this->assertNull($result->description);
    }

    public function test_is_active_default_is_true()
    {
        $result = SemenPortion::create([
            'name' => 'Test Name',
        ]);

        $result->refresh();

        $this->assertTrue($result->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $result = SemenPortion::create([
            'name' => 'Test Name',
            'is_active' => 1
        ]);

        $this->assertTrue($result->is_active);
    }

    public function test_factory()
    {
        $result = SemenPortion::factory()->create();

        $this->assertDatabaseHas('semen_portions', [
            'id' => $result->id,
        ]);

        $this->assertNotNull($result->name);
    }
}
