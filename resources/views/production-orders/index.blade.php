<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>製造指示一覧 | 在庫管理システム</title>
</head>

<body>
    <h1>製造指示一覧</h1>

    <p><a href="{{ route('production-orders.create') }}">新規登録</a></p>

    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>商品名</th>
                <th>数量</th>
                <th>状態</th>
                <th>予定日</th>
                <th>指示者</th>
                <th>操作</th>
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
                <td>
                    @if ($order->status === 'pending')
                    <form action="{{ route('production-orders.complete', $order) }}" method="POST" style="display:inline;" onsubmit="return confirm('この製造指示を完了し、在庫を更新しますか？');">
                        @csrf
                        <button type="submit">完了にする</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $productionOrders->links() }}
</body>

</html>