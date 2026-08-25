<h2 class="mb-3 text-lg font-semibold text-gray-900">部品在庫</h2>
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>部品名</th>
                <th>仕入先</th>
                <th>現在庫数</th>
                <th>単位</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parts as $part)
                @php $isLowStock = $part->currentStock() < 50; @endphp
                <tr>
                    <td>{{ $part->sku }}</td>
                    <td>{{ $part->name }}</td>
                    <td>{{ $part->supplier->name }}</td>
                    <td class="{{ $isLowStock ? 'font-semibold text-red-600' : '' }}">{{ $part->currentStock() }}</td>
                    <td>{{ $part->unit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
