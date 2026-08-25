<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access_customer_list(): void
    {
        $response = $this->get('/customers');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_customer_list(): void
    {
        $user = User::factory()->create();
        $customers = Customer::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/customers');

        $response->assertStatus(200);
        foreach ($customers as $customer) {
            $response->assertSee($customer->name);
        }
    }
    public function test_authenticated_user_can_create_customer(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/customers', [
            'name' => 'テスト納入先',
            'contact_info' => '03-1234-5678',
        ]);

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('customers', [
            'name' => 'テスト納入先',
            'contact_info' => '03-1234-5678',
        ]);
    }

    public function test_customer_creation_fails_without_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/customers', [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('customers', 0);
    }

    public function test_authenticated_user_can_update_customer(): void
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create(['name' => '旧納入先名']);

        $response = $this->actingAs($user)->put("/customers/{$customer->id}", [
            'name' => '新納入先名',
        ]);

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => '新納入先名',
        ]);
    }

    public function test_authenticated_user_can_delete_customer(): void
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $response = $this->actingAs($user)->delete("/customers/{$customer->id}");

        $response->assertRedirect('/customers');
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }
}
