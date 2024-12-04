<?php

namespace Tests\Feature\Animal;

use AllowDynamicProperties;
use App\Models\Animal;
use App\Models\Organisation;
use App\Models\Bolus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

#[AllowDynamicProperties] class AnimalsControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->organisations = Organisation::factory()->count(5)->create();
        $this->boluses = Bolus::factory()->count(5)->create();
    }

    public function test_index_for_non_admin(): void
    {
        $response = $this->actingAs($this->user)->get('/animals');
        $response->assertStatus(200);
    }

    public function test_index_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get('/animals');
        $response->assertStatus(200);
    }

    public function test_index_view_for_non_admin()
    {
        $response = $this->actingAs($this->user)->get(route('animals.index'));
        $response->assertStatus(200);
        $response->assertViewIs('animals.index');
        $response->assertViewHas('animals');
    }

    public function test_index_view_for_admin()
    {
        $response = $this->actingAs($this->admin)->get(route('animals.index'));
        $response->assertStatus(200);
        $response->assertViewIs('animals.index');
        $response->assertViewHas('animals');
    }

    public function test_create_view_for_non_admin()
    {
        $response = $this->actingAs($this->user)->get(route('animals.create'));
        $response->assertStatus(200);
        $response->assertViewIs('animals.create');
    }

    public function test_create_view_for_admin()
    {
        $response = $this->actingAs($this->admin)->get(route('animals.create'));
        $response->assertStatus(200);
        $response->assertViewIs('animals.create');
    }

    public function test_store_for_non_admin()
    {
        $data = Animal::factory()->make()->toArray();
        $response = $this->actingAs($this->user)->post(route('animals.store'), $data);
        $response->assertRedirect(route('animals.index'));
        $this->assertDatabaseHas('animals', $data);
    }

    public function test_store_for_admin()
    {
        $data = Animal::factory()->make()->toArray();
        $response = $this->actingAs($this->admin)->post(route('animals.store'), $data);
        $response->assertRedirect(route('animals.index'));
        $this->assertDatabaseHas('animals', $data);
    }

    public function test_show_view_for_non_admin()
    {
        $animal = Animal::factory()->create();
        $response = $this->actingAs($this->user)->get(route('animals.show', $animal));
        $response->assertStatus(200);
        $response->assertViewIs('animals.show');
        $response->assertViewHas('animal');
    }

    public function test_show_view_for_admin()
    {
        $animal = Animal::factory()->create();
        $response = $this->actingAs($this->admin)->get(route('animals.show', $animal));
        $response->assertStatus(200);
        $response->assertViewIs('animals.show');
        $response->assertViewHas('animal');
    }

    public function test_edit_view_forbidden_for_non_admin()
    {
        $animal = Animal::factory()->create();
        $response = $this->actingAs($this->user)->get(route('animals.edit', $animal));
        $response->assertStatus(403);
        // $response->assertViewIs('animals.edit');
        // $response->assertViewHas('animal');
    }

    public function test_edit_view_for_admin()
    {
        $animal = Animal::factory()->create();
        $response = $this->actingAs($this->admin)->get(route('animals.edit', $animal));
        $response->assertStatus(200);
        $response->assertViewIs('animals.edit');
        $response->assertViewHas('animal');
    }

    public function test_update_forbidden_for_non_admin()
    {
        $animal = Animal::factory()->create();
        $data = [
            'name' => 'Updated Test Animal',
        ];

        $response = $this->actingAs($this->user)->put(route('animals.update', $animal->id), $data);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('animals', $data);
    }

    public function test_update_for_admin()
    {
        $animal = Animal::factory()->create();
        $data = [
            'name' => 'Updated Test Animal',
        ];

        $response = $this->actingAs($this->admin)->put(route('animals.update', $animal->id), $data);
        $response->assertRedirect(route('animals.index'));
        $this->assertDatabaseHas('animals', $data);
    }

    public function test_destroy_forbidden_for_non_admin()
    {
        $animal = Animal::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('animals.destroy', $animal));
        $response->assertStatus(403);
        $this->assertDatabaseMissing('animals', ['id' => $animal->id]);
    }

    public function test_destroy_for_admin()
    {
        $animal = Animal::factory()->create();
        $response = $this->actingAs($this->admin)->delete(route('animals.destroy', $animal));
        $response->assertRedirect(route('animals.index'));
        $this->assertDatabaseMissing('animals', ['id' => $animal->id]);
    }
}
