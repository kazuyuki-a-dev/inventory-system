<x-layouts.app title="在庫変動履歴">
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>日時</th>
                    <th>種別</th>
                    <th>SKU</th>
                    <th>名称</th>
                    <th>入出庫</th>
                    <th>数量</th>
                    <th>メモ</th>
                    <th>担当者</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movements as $movement)
                    <tr>
                        <td>{{ $movement->created_at->format('Y/m/d H:i') }}</td>
                        <td>{{ $movement->stockable instanceof \App\Models\Part ? '部品' : '商品' }}</td>
                        <td>{{ $movement->stockable->sku }}</td>
                        <td>{{ $movement->stockable->name }}</td>
                        <td class="{{ $movement->type === 'in' ? 'font-semibold text-green-600' : 'font-semibold text-red-600' }}">
                            {{ $movement->type === 'in' ? '入庫' : '出庫' }}
                        </td>
                        <td>{{ $movement->quantity }}</td>
                        <td>{{ $movement->memo ?: '-' }}</td>
                        <td>{{ $movement->user->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-500">在庫変動の記録はありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $movements->links() }}
    </div>
</x-layouts.app>
