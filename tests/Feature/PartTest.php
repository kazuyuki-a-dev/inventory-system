<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Part;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_part_list(): void
    {
        $response = $this->get('/parts');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_part_list(): void
    {
        $user = User::factory()->create();
        $parts = Part::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/parts');

        $response->assertStatus(200);
        foreach ($parts as $part) {
            $response->assertSee($part->name);
        }
    }

    public function test_authenticated_user_can_search_part_list(): void
    {
        $user = User::factory()->create();
        Part::factory()->create(['name' => 'ステンレスボルト', 'sku' => 'PT-00001']);
        Part::factory()->create(['name' => '樹脂パッキン', 'sku' => 'PT-00002']);

        $response = $this->actingAs($user)->get('/parts?search=ステンレス');

        $response->assertStatus(200);
        $response->assertSee('ステンレスボルト');
        $response->assertDontSee('樹脂パッキン');

        // SKUでの検索でも絞り込めることを確認
        $response = $this->actingAs($user)->get('/parts?search=PT-00002');

        $response->assertSee('樹脂パッキン');
        $response->assertDontSee('ステンレスボルト');
    }

    public function test_authenticated_user_can_create_part(): void
    {
        $supplier = Supplier::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/parts', [
            'supplier_id' => $supplier->id,
            'sku' => 'PT-TEST01',
            'name' => 'テスト部品',
            'unit' => '個',
            'price' => 500,
        ]);

        $response->assertRedirect('/parts');
        $this->assertDatabaseHas('parts', [
            'name' => 'テスト部品',
            'sku' => 'PT-TEST01',
        ]);
    }

    public function test_part_creation_fails_without_name(): void
    {
        $supplier = Supplier::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/parts', [
            'supplier_id' => $supplier->id,
            'sku' => 'PT-TEST02',
            'name' => '',
            'unit' => '個',
            'price' => 500,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('parts', 0);
    }

    public function test_authenticated_user_can_update_part(): void
    {
        $user = User::factory()->create();
        $part = Part::factory()->create(['name' => '旧部品名']);

        $response = $this->actingAs($user)->put("/parts/{$part->id}", [
            'supplier_id' => $part->supplier_id,
            'sku' => $part->sku,
            'name' => '新部品名',
            'unit' => $part->unit,
            'price' => $part->price,
        ]);

        $response->assertRedirect('/parts');
        $this->assertDatabaseHas('parts', [
            'id' => $part->id,
            'name' => '新部品名',
        ]);
    }

    public function test_authenticated_user_can_delete_part(): void
    {
        $user = User::factory()->create();
        $part = Part::factory()->create();

        $response = $this->actingAs($user)->delete("/parts/{$part->id}");

        $response->assertRedirect('/parts');
        $this->assertDatabaseMissing('parts', [
            'id' => $part->id,
        ]);
    }
}
