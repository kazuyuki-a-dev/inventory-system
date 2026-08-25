<?php

namespace Tests\Feature;

use App\Models\Part;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockMovementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_stock_movement_list(): void
    {
        $response = $this->get('/stocks/movements');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_stock_movement_list(): void
    {
        $user = User::factory()->create();
        $part = Part::factory()->create();
        StockMovement::create([
            'stockable_type' => $part->getMorphClass(),
            'stockable_id' => $part->id,
            'user_id' => $user->id,
            'type' => 'in',
            'quantity' => 150,
            'memo' => 'テスト入庫',
        ]);

        $response = $this->actingAs($user)->get('/stocks/movements');

        $response->assertStatus(200);
        $response->assertSee($part->name);
        $response->assertSee('テスト入庫');
        $response->assertSee('150');
    }
}
