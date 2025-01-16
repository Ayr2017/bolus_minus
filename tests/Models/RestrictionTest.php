<?php

namespace Tests\Models;

use AllowDynamicProperties;
use App\Models\Restriction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;


#[AllowDynamicProperties] class RestrictionTest extends TestCase
{
    use RefreshDatabase;

    //TODO: fillable не соответствует полям в миграции, поэтому тесты не проходят -> исправить миграцию или fillable

    public function test_fillable_matches_table_columns()
    {
        $tableColumns = Schema::getColumnListing('restrictions');
        $fillable = (new Restriction())->getFillable();

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
            'title' => 'Test Title',
            'icon' => 'test-icon.png',
            'is_active' => true,
        ];

        $result = Restriction::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $result->$key);
        }
    }

    public function test_create()
    {
        $data = [
            'name' => 'Test Name',
            'title' => 'Test Title',
            'icon' => 'test-icon.png',
            'is_active' => true,
        ];

        Restriction::create($data);

        $this->assertDatabaseHas('restrictions', $data);
    }

    public function test_read()
    {
        $result = Restriction::create([
            'name' => 'Test Name',
        ]);

        $found = Restriction::find($result->id);

        $this->assertEquals('Test Name', $found->name);
    }

    public function test_update()
    {
        $result = Restriction::create([
            'name' => 'Test Name',
        ]);

        $result->update([
            'name' => 'Updated Name',
            'title' => 'Updated Title',
            'icon' => 'updated-icon.png',
            'is_active' => false
        ]);

        $this->assertDatabaseHas('restrictions', [
            'name' => 'Updated Name',
            'title' => 'Updated Title',
            'icon' => 'updated-icon.png',
            'is_active' => false
        ]);
    }

    public function test_delete()
    {
        $result = Restriction::create([
            'name' => 'Test Name',
        ]);

        $result->delete();

        $this->assertDatabaseMissing('restrictions', [
            'id' => $result->id,
        ]);
    }

    public function test_name_is_unique()
    {
        Restriction::create(['name' => 'Test Name']);
        $this->expectException(QueryException::class);
        Restriction::create(['name' => 'Test Name']);
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);
        Restriction::create(['name' => null]);
    }

    public function test_description_is_nullable()
    {
        $result = Restriction::create([
            'name' => 'Test Name',
            'description' => null,
        ]);

        $this->assertNull($result->description);
    }

    public function test_is_active_default_is_true()
    {
        $result = Restriction::create([
            'name' => 'Test Name',
        ]);

        $result->refresh();

        $this->assertTrue($result->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $result = Restriction::create([
            'name' => 'Test Name',
            'is_active' => 1
        ]);

        $this->assertTrue($result->is_active);
    }

    public function test_factory()
    {
        $result = Restriction::factory()->create();

        $this->assertDatabaseHas('restrictions', [
            'id' => $result->id,
        ]);

        $this->assertNotNull($result->name);
    }
}
