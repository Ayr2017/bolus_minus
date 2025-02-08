<?php

namespace Tests\Models;

use AllowDynamicProperties;
use App\Models\AnimalGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;
use App\Models\Organisation;
use App\Models\Employee;
use Spatie\Permission\Models\Role;


#[AllowDynamicProperties] class AnimalGroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_mass_assignment()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $result = AnimalGroup::create($data);

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

        AnimalGroup::create($data);

        $this->assertDatabaseHas('animal_groups', $data);
    }

    public function test_read()
    {
        $result = AnimalGroup::create([
            'name' => 'Test Name',
        ]);

        $found = AnimalGroup::find($result->id);
        $this->assertEquals('Test Name', $found->name);
    }

    public function test_update()
    {
        $result = AnimalGroup::create([
            'name' => 'Test Name',
            'description' => 'Test Description',
        ]);

        $result->update([
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);

        $this->assertDatabaseHas('animal_groups', [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);
    }

    public function test_delete()
    {
        $result = AnimalGroup::create([
            'name' => 'Test Name',
        ]);

        $result->delete();

        $this->assertDatabaseMissing('animal_groups', [
            'id' => $result->id,
        ]);
    }

    public function test_name_is_unique()
    {
        AnimalGroup::create(['name' => 'Test Name']);
        $this->expectException(QueryException::class);
        AnimalGroup::create(['name' => 'Test Name']);
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);
        AnimalGroup::create(['name' => null]);
    }

    public function test_description_is_nullable()
    {
        $result = AnimalGroup::create([
            'name' => 'Test Name',
            'description' => null,
        ]);

        $this->assertNull($result->description);
    }

    public function test_is_active_default_is_true()
    {
        $result = AnimalGroup::create([
            'name' => 'Test Name',
        ]);

        $result->refresh();

        $this->assertTrue($result->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $result = AnimalGroup::create([
            'name' => 'Test Name',
            'is_active' => 1
        ]);

        $this->assertTrue($result->is_active);
    }

    public function test_factory()
    {
        $result = AnimalGroup::factory()->create();

        $this->assertDatabaseHas('animal_groups', [
            'id' => $result->id,
        ]);

        $this->assertNotNull($result->name);
    }
}
