<?php

namespace Tests\Models;

use AllowDynamicProperties;
use App\Models\StructuralUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;


#[AllowDynamicProperties] class StructuralUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_mass_assignment()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $result = StructuralUnit::create($data);

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

        StructuralUnit::create($data);

        $this->assertDatabaseHas('structural_units', $data);
    }

    public function test_read()
    {
        $result = StructuralUnit::create([
            'name' => 'Test Name',
        ]);

        $found = StructuralUnit::find($result->id);

        $this->assertEquals('Test Name', $found->name);
    }

    public function test_update()
    {
        $result = StructuralUnit::create([
            'name' => 'Test Name',
            'description' => 'Test Description',
        ]);

        $result->update([
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);

        $this->assertDatabaseHas('structural_units', [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);
    }

    public function test_delete()
    {
        $result = StructuralUnit::create([
            'name' => 'Test Name',
        ]);

        $result->delete();

        $this->assertDatabaseMissing('structural_units', [
            'id' => $result->id,
        ]);
    }

    public function test_name_is_unique()
    {
        StructuralUnit::create(['name' => 'Test Name']);
        $this->expectException(QueryException::class);
        StructuralUnit::create(['name' => 'Test Name']);
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);
        StructuralUnit::create(['name' => null]);
    }

    public function test_description_is_nullable()
    {
        $result = StructuralUnit::create([
            'name' => 'Test Name',
            'description' => null,
        ]);

        $this->assertNull($result->description);
    }

    public function test_is_active_default_is_true()
    {
        $result = StructuralUnit::create([
            'name' => 'Test Name',
        ]);

        $result->refresh();

        $this->assertTrue($result->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $result = StructuralUnit::create([
            'name' => 'Test Name',
            'is_active' => 1
        ]);

        $this->assertTrue($result->is_active);
    }

    public function test_factory()
    {
        $result = StructuralUnit::factory()->create();

        $this->assertDatabaseHas('structural_units', [
            'id' => $result->id,
        ]);

        $this->assertNotNull($result->name);
    }
}
