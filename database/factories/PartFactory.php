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
        return [
            'supplier_id' => Supplier::factory(),
            'sku' => 'PT-' . fake()->unique()->numerify('#####'),
            'name' => fake()->words(2, true) . '部品',
            'unit' => fake()->randomElement(['個', '本', 'm', 'kg']),
            'price' => fake()->numberBetween(10, 5000),
        ];
    }
}
