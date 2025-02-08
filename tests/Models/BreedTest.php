<?php

namespace Tests\Models;

use AllowDynamicProperties;
use App\Models\Breed;
use App\Models\Organisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Database\QueryException;


#[AllowDynamicProperties] class BreedTest extends TestCase
{
    use RefreshDatabase;

    public function test_mass_assignment()
    {
        $data = [
            'name' => 'Test Name',
            'type' => 'Test Type',
            'is_active' => true,
        ];

        $result = Breed::create($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $result->$key);
        }
    }

    public function test_create()
    {
        Breed::create([
            'name' => 'Test Name',
        ]);

        $this->assertDatabaseHas('breeds', [
            'name' => 'Test Name',
        ]);
    }

    public function test_read()
    {
        $result = Breed::create([
            'name' => 'Test Name',
        ]);

        $found = Breed::find($result->id);
        $this->assertEquals('Test Name', $found->name);
        $this->assertTrue(Str::isUuid($found->uuid));
    }

    public function test_update()
    {
        $result = Breed::create([
            'name' => 'Test Name',
            'type' => 'Test Type',
            'is_active' => true,
        ]);

        $result->update([
            'name' => 'Updated Name',
            'type' => 'Updated Type',
            'is_active' => false
        ]);

        $this->assertDatabaseHas('breeds', [
            'name' => 'Updated Name',
            'type' => 'Updated Type',
            'is_active' => false
        ]);
    }

    public function test_delete()
    {
        $result = Breed::create([
            'name' => 'Test Name',
        ]);

        $result->delete();

        $this->assertDatabaseMissing('breeds', [
            'id' => $result->id,
        ]);
    }

    public function test_uuid_on_creation()
    {
        $result = Breed::create([
            'name' => 'Test Name',
        ]);

        $uuidString = $result->uuid->toString();
        $this->assertNotNull($uuidString);
        $this->assertTrue(Str::isUuid($uuidString));
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);
        Breed::create(['name' => null]);
    }

    public function test_type_is_nullable()
    {
        $result = Breed::create([
            'name' => 'Test Name',
            'type' => null,
        ]);

        $this->assertNull($result->description);
    }

    public function test_is_active_default_is_true()
    {
        $result = Breed::create([
            'name' => 'Test Name',
        ]);

        $result->refresh();

        $this->assertTrue($result->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $result = Breed::create([
            'name' => 'Test Name',
            'is_active' => 1
        ]);

        $this->assertTrue($result->is_active);
    }

    public function test_has_many_animals()
    {
        $result = Breed::create([
            'name' => 'Test Name',
        ]);

        $animal1 = $result->animals()->create([
            'name' => 'Имя1',
            'number' => '111111',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
        ]);


        $animal2 = $result->animals()->create([
            'name' => 'Имя2',
            'number' => '222222',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
        ]);

        $this->assertCount(2, $result->animals);
        $this->assertTrue($result->animals->contains($animal1));
        $this->assertTrue($result->animals->contains($animal2));
    }

    public function test_factory()
    {
        $result = Breed::factory()->create();

        $this->assertDatabaseHas('breeds', [
            'id' => $result->id,
        ]);

        $this->assertNotNull($result->name);
        $this->assertNotNull($result->uuid);
    }
}
