<h2 class="mb-3 text-lg font-semibold text-gray-900">商品在庫</h2>
<div class="table-wrap mb-8">
    <table class="data-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>商品名</th>
                <th>カテゴリ</th>
                <th>納入先</th>
                <th>現在庫数</th>
                <th>単位</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->customer->name }}</td>
                    <td>{{ $product->currentStock() }}</td>
                    <td>{{ $product->unit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
