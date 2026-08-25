<x-layouts.app title="商品一覧">
    <x-slot:actions>
        <x-button :href="route('products.create')">新規登録</x-button>
    </x-slot:actions>

    <x-flash-message />

    <x-search-form placeholder="商品名・SKUで検索" />

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>商品名</th>
                    <th>カテゴリ</th>
                    <th>納入先</th>
                    <th>単価</th>
                    <th class="text-right">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->customer->name }}</td>
                        <td>{{ number_format($product->price) }}円</td>
                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <x-button variant="secondary" :href="route('products.edit', $product)">編集</x-button>
                                <x-button variant="secondary" :href="route('products.parts.index', $product)">部品表</x-button>
                                <x-delete-button :action="route('products.destroy', $product)" />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</x-layouts.app>
