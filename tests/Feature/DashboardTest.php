<?php

namespace Tests\Feature;

use App\Models\Part;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_low_stock_alert_uses_each_parts_own_threshold(): void
    {
        $user = User::factory()->create();

        $lowThresholdPart = Part::factory()->create([
            'name' => '閾値低め部品',
            'low_stock_threshold' => 10,
        ]);
        $lowThresholdPart->stockMovements()->create([
            'user_id' => $user->id,
            'type' => 'in',
            'quantity' => 100,
        ]);

        $highThresholdPart = Part::factory()->create([
            'name' => '閾値高め部品',
            'low_stock_threshold' => 200,
        ]);
        $highThresholdPart->stockMovements()->create([
            'user_id' => $user->id,
            'type' => 'in',
            'quantity' => 100,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        // 在庫100 < 閾値200 の部品は低在庫アラートに表示される
        $response->assertSee('閾値高め部品');
        // 在庫100 >= 閾値10 の部品は表示されない
        $response->assertDontSee('閾値低め部品');
    }
}
