<?php

namespace Feature\Models;

use AllowDynamicProperties;
use App\Models\RestrictionReason;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;


#[AllowDynamicProperties] class RestrictionReasonTest extends TestCase
{
    use RefreshDatabase;

    public function test_mass_assignment()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $result = RestrictionReason::create($data);

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

        RestrictionReason::create($data);

        $this->assertDatabaseHas('restriction_reasons', $data);
    }

    public function test_read()
    {
        $result = RestrictionReason::create([
            'name' => 'Test Name',
        ]);

        $found = RestrictionReason::find($result->id);

        $this->assertEquals('Test Name', $found->name);
    }

    public function test_update()
    {
        $result = RestrictionReason::create([
            'name' => 'Test Name',
            'description' => 'Test Description',
        ]);

        $result->update([
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);

        $this->assertDatabaseHas('restriction_reasons', [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);
    }

    public function test_delete()
    {
        $result = RestrictionReason::create([
            'name' => 'Test Name',
        ]);

        $result->delete();

        $this->assertDatabaseMissing('restriction_reasons', [
            'id' => $result->id,
        ]);
    }

    public function test_name_is_unique()
    {
        RestrictionReason::create(['name' => 'Test Name']);
        $this->expectException(QueryException::class);
        RestrictionReason::create(['name' => 'Test Name']);
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);
        RestrictionReason::create(['name' => null]);
    }

    public function test_description_is_nullable()
    {
        $result = RestrictionReason::create([
            'name' => 'Test Name',
            'description' => null,
        ]);

        $this->assertNull($result->description);
    }

    public function test_is_active_default_is_true()
    {
        $result = RestrictionReason::create([
            'name' => 'Test Name',
        ]);

        $result->refresh();

        $this->assertTrue($result->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $result = RestrictionReason::create([
            'name' => 'Test Name',
            'is_active' => 1
        ]);

        $this->assertTrue($result->is_active);
    }

    public function test_factory()
    {
        $result = RestrictionReason::factory()->create();

        $this->assertDatabaseHas('restriction_reasons', [
            'id' => $result->id,
        ]);

        $this->assertNotNull($result->name);
    }
}
