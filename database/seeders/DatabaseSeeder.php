<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Part;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. 管理者ユーザーを1人作成(ログイン確認用)
        User::factory()->create([
            'name' => 'テスト管理者',
            'email' => 'admin@example.com',
        ]);

        // 2. カテゴリを5件作成
        $categories = Category::factory(5)->create();

        // 3. 仕入先を8件作成
        $suppliers = Supplier::factory(8)->create();

        // 3b. 納入先を8件作成
        $customers = Customer::factory(8)->create();

        // 4. 商品を10件作成(既存のカテゴリ・納入先からランダムに紐付け)
        $products = Product::factory(10)
            ->recycle($categories)
            ->recycle($customers)
            ->create();

        // 5. 部品を20件作成(既存の仕入先からランダムに紐付け)
        $parts = Part::factory(20)
            ->recycle($suppliers)
            ->create();

        // 6. 各商品に2〜4個の部品をランダムに割り当て(BOM作成)
        $products->each(function (Product $product) use ($parts) {
            $assignedParts = $parts->random(rand(2, 4));

            foreach ($assignedParts as $part) {
                $product->parts()->attach($part->id, [
                    'quantity_required' => rand(1, 10),
                ]);
            }
        });

        // 7. 各部品に初期在庫を入庫として登録
        $parts->each(function ($part) {
            StockMovement::create([
                'stockable_type' => $part->getMorphClass(),
                'stockable_id' => $part->id,
                'user_id' => 1,
                'type' => 'in',
                'quantity' => rand(100, 500),
                'memo' => '初期在庫登録',
            ]);
        });
    }
}
