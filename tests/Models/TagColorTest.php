<?php

namespace Feature\Models;

use AllowDynamicProperties;
use App\Models\TagColor;
use Tests\TestCase;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Foundation\Testing\RefreshDatabase;


#[AllowDynamicProperties] class TagColorTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_no_fillable()
    {
        $this->assertEmpty((new TagColor)->getFillable());

        $this->expectException(MassAssignmentException::class);

        TagColor::create([
            'name' => 'Test Name',
            'slug' => 'test-slug',
            'hex' => '#ff0000',
        ]);
    }

    public function test_seeder_data()
    {
        $tagColors = TagColor::all();

        $this->assertNotEmpty($tagColors);

        foreach ($tagColors as $tagColor) {
            $this->assertIsString($tagColor->name);
            $this->assertIsString($tagColor->slug);
            $this->assertMatchesRegularExpression('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $tagColor->hex);
        }
    }
}
