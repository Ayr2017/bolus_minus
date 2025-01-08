<?php

namespace Feature\Controllers\Api;

use AllowDynamicProperties;
use App\Models\TagColor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class TagColorControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function test_index_for_admin()
    {
        $response = $this->actingAs($this->admin)->getJson(route('api.tag-colors.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'success',
            'error',
            'data' => [
                'items' => [
                    '*' => [
                        'id',
                        'name',
                        'slug',
                        'hex', //TODO: учтонить, надо ли возвращать hex 
                        'created_at',
                        'updated_at',
                    ],
                ],
                "current_page",
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]
        ]);

        $responseData = $response->json();
        $items = $responseData['data']['items'];

        foreach ($items as $item) {
            // TODO: поправить метод toArray в TagColorResource, а то slug возвращается как null
            $this->assertIsString($item['name']);
            $this->assertIsString($item['slug']);
            $this->assertIsString($item['hex']); //TODO: учтонить, надо ли возвращать hex 
            $this->assertIsString($item['created_at']);
            $this->assertIsString($item['updated_at']);
            $this->assertMatchesRegularExpression('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $item['hex']); //TODO: учтонить, надо ли возвращать hex 
        }
    }
}
