<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $descriptors = ['標準', '業務用', '高耐久', '汎用', '精密', '省スペース', '軽量', 'コンパクト'];
        $products = ['ラック', 'ユニット', 'アセンブリ', 'キット', 'モジュール', 'フレーム', 'パネル', 'ケース'];

        return [
            'category_id' => Category::factory(),
            'customer_id' => Customer::factory(),
            'sku' => 'P-' . fake()->unique()->numerify('#####'),
            'name' => fake()->randomElement($descriptors) . fake()->randomElement($products),
            'unit' => fake()->randomElement(['個', '箱', 'セット']),
            'price' => fake()->numberBetween(500, 50000),
        ];
    }
}
