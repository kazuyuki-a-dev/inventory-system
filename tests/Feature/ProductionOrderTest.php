<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductionOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_production_order_list(): void
    {
        $response = $this->get('/production-orders');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_production_order_list(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        ProductionOrder::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'quantity' => 5,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/production-orders');

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_authenticated_user_can_search_production_order_list_by_product(): void
    {
        $user = User::factory()->create();
        $matchingProduct = Product::factory()->create(['name' => '標準ラック', 'sku' => 'P-00001']);
        $otherProduct = Product::factory()->create(['name' => '軽量フレーム', 'sku' => 'P-00002']);

        ProductionOrder::create([
            'product_id' => $matchingProduct->id,
            'user_id' => $user->id,
            'quantity' => 5,
            'status' => 'pending',
        ]);
        ProductionOrder::create([
            'product_id' => $otherProduct->id,
            'user_id' => $user->id,
            'quantity' => 3,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get('/production-orders?search=標準');

        $response->assertStatus(200);
        $response->assertSee('標準ラック');
        $response->assertDontSee('軽量フレーム');
    }
}
