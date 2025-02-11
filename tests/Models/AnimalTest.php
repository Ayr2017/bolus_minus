<?php

namespace Tests\Models;

use AllowDynamicProperties;
use App\Models\Animal;
use App\Models\AnimalGroup;
use App\Models\Bolus;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Models\Organisation;
use App\Models\Breed;
use App\Models\Status;


#[AllowDynamicProperties] class AnimalTest extends TestCase
{
    use RefreshDatabase;

    // public function test_fillable_matches_table_columns()
    // {
    //     $tableColumns = Schema::getColumnListing('animals');
    //     $fillable = (new Animal())->getFillable();

    //     foreach ($fillable as $field) {
    //         $this->assertContains($field, $tableColumns, "Поле '$field' указано в fillable, но отсутствует в таблице.");
    //     }

    //     foreach ($tableColumns as $column) {
    //         if ($column !== 'id' && $column !== 'created_at' && $column !== 'updated_at') {
    //             $this->assertContains($column, $fillable, "Колонка '$column' есть в таблице, но отсутствует в fillable.");
    //         }
    //     }
    // }

    public function test_mass_assignment()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'breed_id' => 1,
            'number_rshn' => 'Test Number RSHN',
            'bolus_id' => 1,
            'number_rf' => 'Test Number RF',
            'number_tavro' => 'Test Number TAVRO',
            'number_tag' => 'Test Number TAG',
            'tag_color' => 'Test Tag Color',
            'number_collar' => 'Test Number Collar',
            'status_id' => 1,
            'sex' => 'male',
            'withdrawn_at' => '2000-01-01',
            'is_active' => 1,
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        foreach ($data as $key => $value) {
            if (in_array($key, ['birthday', 'withdrawn_at'])) {
                $this->assertSame($value, $item->$key->format('Y-m-d'));
            } else {
                $this->assertEquals($value, $item->$key);
            }
        }
    }

    public function test_create()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01 00:00:00',
            'animal_group_id' => 1,
        ];

        Animal::create($data);

        $this->assertDatabaseHas('animals', $data);
    }

    public function test_read()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01 00:00:00',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);
        $foundItem = Animal::find($item->id);

        $this->assertEquals('Test Name', $foundItem->name);
        $this->assertEquals('Test Number', $foundItem->number);
        $this->assertEquals(1, $foundItem->organisation_id);
        $this->assertEquals('2000-01-01 00:00:00', $foundItem->birthday);
    }

    public function test_update()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01 00:00:00',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $updatedData = [
            'name' => 'Updated Test Name',
            'number' => 'Updated Test Number',
            'organisation_id' => 2,
            'birthday' => '2010-01-01 00:00:00',
            'animal_group_id' => 2,
        ];

        $item->update($updatedData);

        $this->assertDatabaseHas('animals', $updatedData);
    }

    public function test_delete_soft()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01 00:00:00',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $item->delete();

        $this->assertSoftDeleted('animals', ['id' => $item->id,]);
    }

    public function test_is_active_default_is_true()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $item->refresh();

        $this->assertTrue($item->is_active);
    }

    public function test_is_active_casts_to_boolean()
    {
        $data = [
            'is_active' => 1,
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertTrue($item->is_active);
    }

    public function test_uuid_on_creation()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $uuidString = $item->uuid->toString();
        $this->assertNotNull($uuidString);
        $this->assertTrue(Str::isUuid($uuidString));
    }

    public function test_name_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        Animal::create($data);
    }

    public function test_number_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Test Name',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        Animal::create($data);
    }

    public function test_birthday_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'animal_group_id' => 1,
        ];

        Animal::create($data);
    }

    public function test_animal_group_id_is_required()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
        ];

        Animal::create($data);
    }

    public function test_number_rshn_is_nullable()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertNull($item->number_rshn);
    }

    public function test_bolus_id_is_nullable()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertNull($item->bolus_id);
    }

    public function test_number_rf_is_nullable()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertNull($item->number_rf);
    }

    public function test_number_tavro_is_nullable()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertNull($item->number_tavro);
    }

    public function test_number_tag_is_nullable()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertNull($item->number_tag);
    }

    public function test_tag_color_is_nullable()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertNull($item->tag_color);
    }

    public function test_number_collar_is_nullable()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertNull($item->number_collar);
    }

    public function test_withdrawn_at_is_nullable()
    {
        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);

        $this->assertNull($item->number_collar);
    }

    public function test_organisation_is_organisation()
    {
        $organisation = Organisation::factory()->create();

        $item = Animal::create(
            [
                'name' => 'Test Name',
                'number' => 'Test Number',
                'organisation_id' => $organisation->id,
                'birthday' => '2000-01-01',
                'animal_group_id' => 1,
            ]
        );

        $this->assertInstanceOf(Organisation::class, $item->organisation);
        $this->assertEquals($organisation->id, $item->organisation->id);
    }

    public function test_animal_group_is_animal_group()
    {
        $animalGroup = AnimalGroup::factory()->create();

        $item = Animal::create(
            [
                'name' => 'Test Name',
                'number' => 'Test Number',
                'organisation_id' => 1,
                'birthday' => '2000-01-01',
                'animal_group_id' => $animalGroup->id,
            ]
        );

        $this->assertInstanceOf(AnimalGroup::class, $item->animalGroup);
        $this->assertEquals($animalGroup->id, $item->animalGroup->id);
    }

    public function test_breed_is_breed()
    {
        $breed = Breed::factory()->create();

        $item = Animal::create(
            [
                'name' => 'Test Name',
                'number' => 'Test Number',
                'organisation_id' => 1,
                'birthday' => '2000-01-01',
                'breed_id' => $breed->id,
                'animal_group_id' => 1,
            ]
        );

        $this->assertInstanceOf(Breed::class, $item->breed);
        $this->assertEquals($breed->id, $item->breed->id);
    }

    public function test_bolus_is_bolus()
    {
        $bolus = Bolus::factory()->create();

        $item = Animal::create(
            [
                'name' => 'Test Name',
                'number' => 'Test Number',
                'organisation_id' => 1,
                'birthday' => '2000-01-01',
                'bolus_id' => $bolus->id,
                'animal_group_id' => 1,
            ]
        );

        $this->assertInstanceOf(Bolus::class, $item->bolus);
        $this->assertEquals($bolus->id, $item->bolus->id);
    }

    public function test_status_is_status()
    {
        $status = Status::query()->first();

        $item = Animal::create(
            [
                'name' => 'Test Name',
                'number' => 'Test Number',
                'organisation_id' => 1,
                'birthday' => '2000-01-01',
                'status_id' => $status->id,
                'animal_group_id' => 1,
            ]
        );

        $this->assertInstanceOf(Status::class, $item->status);
        $this->assertEquals($status->id, $item->status->id);
    }

    public function test_sex_is_valid_enum()
    {
        $validValues = ['male', 'female'];

        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'sex' => 'male',
            'animal_group_id' => 1,
        ];

        $item = Animal::create($data);
        $this->assertContains($item->sex, $validValues);
    }

    public function test_sex_is_not_invalid_enum()
    {
        $this->expectException(QueryException::class);

        $data = [
            'name' => 'Test Name',
            'number' => 'Test Number',
            'organisation_id' => 1,
            'birthday' => '2000-01-01',
            'sex' => 'Test',
            'animal_group_id' => 1,
        ];

        Animal::create($data);
    }

    public function test_factory()
    {
        $item = Animal::factory()->create();

        $this->assertDatabaseHas('animals', ['id' => $item->id]);
    }
}
