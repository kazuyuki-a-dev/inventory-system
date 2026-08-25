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
        </ul>
    </nav>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
</body>

</html>