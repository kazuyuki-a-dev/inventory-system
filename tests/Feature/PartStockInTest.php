<?php

namespace Tests\Feature;

use App\Models\Part;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartStockInTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_register_stock_in(): void
    {
        $user = User::factory()->create();
        $part = Part::factory()->create();

        $response = $this->actingAs($user)->post("/parts/{$part->id}/stock-in", [
            'quantity' => 50,
            'memo' => 'テスト仕入先から入荷',
        ]);

        $response->assertRedirect('/parts');
        $this->assertDatabaseHas('stock_movements', [
            'stockable_type' => Part::class,
            'stockable_id' => $part->id,
            'type' => 'in',
            'quantity' => 50,
            'memo' => 'テスト仕入先から入荷',
        ]);
        $this->assertEquals(50, $part->fresh()->currentStock());
    }

    public function test_stock_in_fails_without_quantity(): void
    {
        $user = User::factory()->create();
        $part = Part::factory()->create();

        $response = $this->actingAs($user)->post("/parts/{$part->id}/stock-in", [
            'quantity' => '',
        ]);

        $response->assertSessionHasErrors('quantity');
        $this->assertDatabaseCount('stock_movements', 0);
        $this->assertEquals(0, $part->fresh()->currentStock());
    }
}
