<?php

namespace Tests\Feature;

use App\Models\Part;
use App\Models\Product;
use App\Models\ProductionOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductionOrderCompletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_completion_succeeds_when_stock_is_sufficient(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $part = Part::factory()->create();

        // 商品には部品が3個必要、というBOMを設定
        $product->parts()->attach($part->id, ['quantity_required' => 3]);

        // 部品の初期在庫を100個入庫しておく
        $part->stockMovements()->create([
            'user_id' => $user->id,
            'type' => 'in',
            'quantity' => 100,
        ]);

        $order = ProductionOrder::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'quantity' => 10,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post("/production-orders/{$order->id}/complete");

        $response->assertRedirect('/production-orders');

        // ステータスが completed に変わっていることを確認
        $this->assertDatabaseHas('production_orders', [
            'id' => $order->id,
            'status' => 'completed',
        ]);

        // 部品が30個(3個×10)出庫されたことを確認
        $this->assertDatabaseHas('stock_movements', [
            'stockable_type' => Part::class,
            'stockable_id' => $part->id,
            'type' => 'out',
            'quantity' => 30,
        ]);

        // 商品が10個入庫されたことを確認
        $this->assertDatabaseHas('stock_movements', [
            'stockable_type' => Product::class,
            'stockable_id' => $product->id,
            'type' => 'in',
            'quantity' => 10,
        ]);

        // 最終的な部品在庫が70個(100-30)になっていることを確認
        $this->assertEquals(70, $part->fresh()->currentStock());    }

    public function test_completion_fails_when_stock_is_insufficient(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $part = Part::factory()->create();

        // 商品には部品が3個必要
        $product->parts()->attach($part->id, ['quantity_required' => 3]);

        // 部品の在庫はわずか5個しかない(10個作るには30個必要なので不足)
        $part->stockMovements()->create([
            'user_id' => $user->id,
            'type' => 'in',
            'quantity' => 5,
        ]);

        $order = ProductionOrder::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'quantity' => 10,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post("/production-orders/{$order->id}/complete");

        $response->assertSessionHasErrors('status');

        // ステータスは pending のまま変わっていないことを確認
        $this->assertDatabaseHas('production_orders', [
            'id' => $order->id,
            'status' => 'pending',
        ]);

        // 在庫移動が一切記録されていないこと(ロールバックされたこと)を確認
        $this->assertDatabaseCount('stock_movements', 1); // 最初の入庫5個分のみ

        // 部品在庫が5個のまま変わっていないことを確認
        $this->assertEquals(5, $part->fresh()->currentStock());
    }

    public function test_completion_fails_when_order_is_already_completed(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $order = ProductionOrder::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'quantity' => 10,
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $response = $this->actingAs($user)->post("/production-orders/{$order->id}/complete");

        $response->assertSessionHasErrors('status');

        // 在庫移動が一切発生していないことを確認(二重処理されていない)
        $this->assertDatabaseCount('stock_movements', 0);
    }
}
