<?php

namespace Tests\Feature\Controllers\NotApi;

use AllowDynamicProperties;
use App\Models\Bolus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class BolusesControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->boluses = Bolus::factory()->count(10)->create();
    }

    /**
     * @return void
     */
    public function test_non_admin_user_cannot_access_index_route(): void
    {
        $response = $this->actingAs($this->user)->get('/boluses');
        $response->assertStatus(403);
    }
    /**
     * @return void
     */
    public function test_admin_user_can_access_index_route(): void
    {
        $response = $this->actingAs($this->admin)->get('/boluses');
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_non_admin_user_cannot_access_show_route(): void
    {
        $this->boluses->each(function ($bolus) {
            $response = $this->actingAs($this->user)->get('/boluses/' . $bolus->id);
            $response->assertStatus(403);
        });
    }

    /**
     * @return void
     */
    public function test_admin_user_can_access_show_route(): void
    {
        $this->boluses->each(function ($bolus) {
            $response = $this->actingAs($this->admin)->get('/boluses/' . $bolus->id);
            $response->assertStatus(200);
        });
    }

    /**
     * @return void
     */
    public function test_non_admin_user_cannot_create_bolus(): void
    {
        $bolusData = Bolus::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('boluses.store'), $bolusData);
        $response->assertStatus(403);
    }

    /**
     * @return void
     */
    public function test_admin_user_can_create_bolus(): void
    {
        $bolusData = Bolus::factory()->make()->toArray();
        $response = $this->actingAs($this->admin)->post(route('boluses.store'), $bolusData);
        $response->assertStatus(302);
        $response->assertRedirect('/boluses');
    }
}
