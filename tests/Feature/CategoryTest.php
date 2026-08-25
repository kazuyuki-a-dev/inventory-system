<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_category_list(): void
    {
        $response = $this->get('/categories');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_category_list(): void
    {
        $user = User::factory()->create();
        $categories = Category::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/categories');

        $response->assertStatus(200);
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }

    public function test_authenticated_user_can_create_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/categories', [
            'name' => 'テストカテゴリ',
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'テストカテゴリ',
        ]);
    }

    public function test_category_creation_fails_without_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/categories', [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('categories', 0);
    }

    public function test_authenticated_user_can_update_category(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['name' => '旧カテゴリ名']);

        $response = $this->actingAs($user)->put("/categories/{$category->id}", [
            'name' => '新カテゴリ名',
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => '新カテゴリ名',
        ]);
    }

    public function test_authenticated_user_can_delete_category(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->delete("/categories/{$category->id}");

        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

}
