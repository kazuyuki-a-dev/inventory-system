<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_product_list(): void
    {
        $response = $this->get('/products');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_product_list(): void
    {
        $user = User::factory()->create();
        $products = Product::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    public function test_authenticated_user_can_create_product(): void
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/products', [
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'sku' => 'P-TEST01',
            'name' => 'テスト商品',
            'unit' => '個',
            'price' => 1000,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'sku' => 'P-TEST01',
        ]);
    }

    public function test_product_creation_fails_without_name(): void
    {
        $category = Category::factory()->create();
        $supplier = Supplier::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/products', [
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'sku' => 'P-TEST02',
            'name' => '',
            'unit' => '個',
            'price' => 1000,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('products', 0);
    }


    public function test_authenticated_user_can_update_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['name' => '旧プロダクト名']);

        $response = $this->actingAs($user)->put("/products/{$product->id}", [
            'category_id' => $product->category_id,
            'supplier_id' => $product->supplier_id,
            'sku' => $product->sku,
            'name' => '新プロダクト名',
            'unit' => $product->unit,
            'price' => $product->price,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => '新プロダクト名',
        ]);
    }

    public function test_authenticated_user_can_delete_product(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->delete("/products/{$product->id}");

        $response->assertRedirect('/products');
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }
}
