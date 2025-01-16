<?php

namespace Tests\Models;

use AllowDynamicProperties;
use App\Models\ZootechnicalExitReason;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\QueryException;


#[AllowDynamicProperties] class ZootechnicalExitReasonTest extends TestCase
{
    use RefreshDatabase;

    public function test_mass_assignment()
    {
        $data = [
            'name' => 'Test Name',
            'description' => 'Test Description',
            'is_active' => true,
        ];

        $result = ZootechnicalExitReason::create($data);

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

        ZootechnicalExitReason::create($data);

        $this->assertDatabaseHas('zootechnical_exit_reasons', $data);
    }

    public function test_read()
    {
        $result = ZootechnicalExitReason::create([
            'name' => 'Test Name',
        ]);

        $found = ZootechnicalExitReason::find($result->id);

        $this->assertEquals('Test Name', $found->name);
    }

    public function test_update()
    {
        $result = ZootechnicalExitReason::create([
            'name' => 'Test Name',
            'description' => 'Test Description',
        ]);

        $result->update([
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);

        $this->assertDatabaseHas('zootechnical_exit_reasons', [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'is_active' => false
        ]);
    }

    public function test_delete()
    {
        $result = ZootechnicalExitReason::create([
            'name' => 'Test Name',
        ]);

        $result->delete();

        $this->assertDatabaseMissing('zootechnical_exit_reasons', [
            'id' => $result->id,
        ]);
    }

    public function test_name_is_unique()
    {
        ZootechnicalExitReason::create(['name' => 'Test Name']);
        $this->expectException(QueryException::class);
        ZootechnicalExitReason::create(['name' => 'Test Name']);
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);
        ZootechnicalExitReason::create(['name' => null]);
    }

    public function test_description_is_nullable()
    {
        $result = ZootechnicalExitReason::create([
            'name' => 'Test Name',
            'description' => null,
        ]);

        $this->assertNull($result->description);
    }

    public function test_is_active_default_is_true()
    {
        $result = ZootechnicalExitReason::create([
            'name' => 'Test Name',
        ]);

        $result->refresh();

        $this->assertTrue($result->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $result = ZootechnicalExitReason::create([
            'name' => 'Test Name',
            'is_active' => 1
        ]);

        $this->assertTrue($result->is_active);
    }

    public function test_factory()
    {
        $result = ZootechnicalExitReason::factory()->create();

        $this->assertDatabaseHas('zootechnical_exit_reasons', [
            'id' => $result->id,
        ]);

        $this->assertNotNull($result->name);
    }
}
