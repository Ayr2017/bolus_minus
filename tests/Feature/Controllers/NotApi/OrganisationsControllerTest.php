<?php

namespace Tests\Feature\Controllers\NotApi;

use App\Models\Organisation;
use App\Models\StructuralUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganisationsControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->organisations = Organisation::factory()->count(10)->create();
        $this->structuralUnit = StructuralUnit::factory()->create();
    }

    public function test_non_admin_user_cannot_access_index_route(): void
    {
        $response = $this->actingAs($this->user)->get('/organisations');
        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_index_route(): void
    {
        $response = $this->actingAs($this->admin)->get('/organisations');
        $response->assertStatus(200);
    }

    public function test_non_admin_user_cannot_access_show_route(): void
    {
        $this->organisations->each(function ($organisation) {
            $response = $this->actingAs($this->user)->get('/organisations/' . $organisation->id);
            $response->assertStatus(403);
        });
    }

    public function test_admin_user_can_access_show_route(): void
    {
        $this->organisations->each(function ($organisation) {
            $response = $this->actingAs($this->admin)->get('/organisations/' . $organisation->id);
            $response->assertStatus(200);
        });
    }

    public function test_non_admin_user_cannot_create_organisation(): void
    {
        $organisationData = Organisation::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('organisations.store'), $organisationData);
        $response->assertStatus(403);
    }

    public function test_admin_user_can_create_organisation(): void
    {
        $organisationData = Organisation::factory()->make(['structural_unit' => $this->structuralUnit])->toArray();
        $response = $this->actingAs($this->admin)->post(route('organisations.store'), $organisationData);
        $response->assertStatus(302);
        $response->assertRedirect('/organisations');
    }
}
