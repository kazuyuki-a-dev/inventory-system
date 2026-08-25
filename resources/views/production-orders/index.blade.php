<x-layouts.app title="製造指示一覧">
    <x-slot:actions>
        <x-button :href="route('production-orders.create')">新規登録</x-button>
    </x-slot:actions>

    <x-flash-message />
    <x-validation-errors />

    <x-search-form placeholder="商品名・SKUで検索" />

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品名</th>
                    <th>数量</th>
                    <th>状態</th>
                    <th>予定日</th>
                    <th>指示者</th>
                    <th class="text-right">操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productionOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->planned_date?->format('Y/m/d') }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td class="text-right">
                            @if ($order->status === 'pending')
                                <form action="{{ route('production-orders.complete', $order) }}" method="POST" class="inline" onsubmit="return confirm('この製造指示を完了し、在庫を更新しますか？');">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">完了にする</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $productionOrders->appends(request()->query())->links() }}
    </div>
</x-layouts.app>
