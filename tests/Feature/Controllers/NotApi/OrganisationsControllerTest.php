<?php

namespace Tests\Feature\Controllers\NotApi;

use AllowDynamicProperties;
use App\Models\Organisation;
use App\Models\StructuralUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class OrganisationsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get('/organisations');
        $response->assertStatus(200);
    }

    public function test_index_forbidden_for_non_admin(): void
    {
        $response = $this->actingAs($this->user)->get('/organisations');
        $response->assertStatus(403);
    }

    public function test_show_for_admin(): void
    {
        $items = Organisation::all();
        $items->each(function ($organisation) {
            $response = $this->actingAs($this->admin)->get('/organisations/' . $organisation->id);
            $response->assertStatus(200);
        });
    }

    public function test_show_forbidden_for_non_admin(): void
    {
        $items = Organisation::all();
        $items->each(function ($organisation) {
            $response = $this->actingAs($this->user)->get('/organisations/' . $organisation->id);
            $response->assertStatus(403);
        });
    }

    public function test_create_for_admin(): void
    {
        $data = Organisation::factory()->make()->toArray();
        $response = $this->actingAs($this->admin)->post(route('organisations.store'), $data);
        $response->assertRedirect(route('organisations.index'));
    }

    public function test_create_forbidden_for_non_admin(): void
    {
        $data = Organisation::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('organisations.store'), $data);
        $response->assertStatus(403);
    }
}
