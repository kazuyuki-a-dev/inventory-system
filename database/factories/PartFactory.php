<?php

namespace Database\Factories;

use App\Models\Part;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Part>
 */
class PartFactory extends Factory
{
    public function definition(): array
    {
        $materials = ['ステンレス', 'アルミ', '樹脂', '真鍮', '鉄', 'ゴム', '銅'];
        $components = ['ボルト', 'ナット', 'ワッシャー', 'ブラケット', 'パッキン', 'スプリング', 'コネクタ', 'ケーブル', '基板', 'カバー'];

        return [
            'supplier_id' => Supplier::factory(),
            'sku' => 'PT-' . fake()->unique()->numerify('#####'),
            'name' => fake()->randomElement($materials) . fake()->randomElement($components),
            'unit' => fake()->randomElement(['個', '本', 'm', 'kg']),
            'price' => fake()->numberBetween(10, 5000),
        ];
    }
}
