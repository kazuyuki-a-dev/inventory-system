<x-layouts.app title="ダッシュボード">
    <p class="mb-6 text-gray-600">ようこそ、{{ auth()->user()->name }}さん</p>

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="card">
            <p class="text-sm text-gray-500">登録商品数</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $productCount }}件</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-500">登録部品数</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $partCount }}件</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-500">未着手の製造指示</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $pendingOrderCount }}件</p>
        </div>
    </div>

    <h2 class="mb-3 text-lg font-semibold text-gray-900">在庫少量アラート(閾値: {{ $lowStockThreshold }}個未満)</h2>

    @if ($lowStockParts->isEmpty())
        <p class="text-sm text-gray-600">在庫が少ない部品はありません。</p>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>部品名</th>
                        <th>現在庫数</th>
                        <th>単位</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lowStockParts as $part)
                        <tr>
                            <td>{{ $part->sku }}</td>
                            <td>{{ $part->name }}</td>
                            <td class="font-semibold text-red-600">{{ $part->currentStock() }}</td>
                            <td>{{ $part->unit }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-layouts.app>
