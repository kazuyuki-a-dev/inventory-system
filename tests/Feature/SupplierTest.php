<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Supplier;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access_supplier_list(): void
    {
        $response = $this->get('/suppliers');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_supplier_list(): void
    {
        $user = User::factory()->create();
        $suppliers = Supplier::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/suppliers');

        $response->assertStatus(200);
        foreach ($suppliers as $supplier) {
            $response->assertSee($supplier->name);
        }
    }
    public function test_authenticated_user_can_create_supplier(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/suppliers', [
            'name' => 'テスト仕入先',
            'contact_info' => '03-1234-5678',
        ]);

        $response->assertRedirect('/suppliers');
        $this->assertDatabaseHas('suppliers', [
            'name' => 'テスト仕入先',
            'contact_info' => '03-1234-5678',
        ]);
    }

    public function test_supplier_creation_fails_without_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/suppliers', [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('suppliers', 0);
    }

    public function test_authenticated_user_can_update_supplier(): void
    {
        $user = User::factory()->create();
        $supplier = Supplier::factory()->create(['name' => '旧カテゴリ名']);

        $response = $this->actingAs($user)->put("/suppliers/{$supplier->id}", [
            'name' => '新カテゴリ名',
        ]);

        $response->assertRedirect('/suppliers');
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'name' => '新カテゴリ名',
        ]);
    }

    public function test_authenticated_user_can_delete_supplier(): void
    {
        $user = User::factory()->create();
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($user)->delete("/suppliers/{$supplier->id}");

        $response->assertRedirect('/suppliers');
        $this->assertDatabaseMissing('suppliers', [
            'id' => $supplier->id,
        ]);
    }
}
