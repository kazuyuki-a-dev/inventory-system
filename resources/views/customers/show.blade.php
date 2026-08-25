<x-layouts.app :title="$customer->name . 'の取引一覧'">
    <p class="mb-6 text-sm text-gray-600">{{ $customer->name }}向けの商品一覧</p>

    @if ($customer->products->isEmpty())
        <p class="text-sm text-gray-600">取引のある商品はありません。</p>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>商品名</th>
                        <th>単価</th>
                        <th class="text-right">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customer->products as $product)
                        <tr>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->price) }}円</td>
                            <td class="text-right">
                                <x-button variant="secondary" :href="route('products.edit', $product)">編集</x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <p class="mt-6">
        <a href="{{ route('customers.index') }}" class="text-sm text-brand hover:underline">納入先一覧に戻る</a>
    </p>
</x-layouts.app>
