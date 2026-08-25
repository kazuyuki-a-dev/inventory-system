<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ダッシュボード | 在庫管理システム</title>
</head>

<body>
    <h1>ようこそ、{{ auth()->user()->name }}さん</h1>

    <nav>
        <ul>
            <li><a href="{{ route('categories.index') }}">カテゴリ管理</a></li>
            <li><a href="{{ route('suppliers.index') }}">仕入先管理</a></li>
            <li><a href="{{ route('products.index') }}">商品管理</a></li>
            <li><a href="{{ route('parts.index') }}">部品管理</a></li>
            <li><a href="{{ route('production-orders.index') }}">製造指示</a></li>
            <li><a href="{{ route('stocks.index') }}">在庫一覧</a></li>
        </ul>
    </nav>

    <hr>

    <h2>サマリー</h2>
    <ul>
        <li>登録商品数: {{ $productCount }}件</li>
        <li>登録部品数: {{ $partCount }}件</li>
        <li>未着手の製造指示: {{ $pendingOrderCount }}件</li>
    </ul>

    <h2>在庫少量アラート(閾値: {{ $lowStockThreshold }}個未満)</h2>

    @if ($lowStockParts->isEmpty())
    <p>在庫が少ない部品はありません。</p>
    @else
    <table border="1" cellpadding="8">
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
                <td style="color: red;">{{ $part->currentStock() }}</td>
                <td>{{ $part->unit }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <hr>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
</body>

</html>