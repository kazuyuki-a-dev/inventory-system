<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>在庫一覧 | 在庫管理システム</title>
</head>

<body>
    <h1>在庫一覧</h1>

    <p><a href="{{ route('dashboard') }}">ダッシュボードに戻る</a></p>

    <h2>商品在庫</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>SKU</th>
                <th>商品名</th>
                <th>カテゴリ</th>
                <th>仕入先</th>
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
                <td>{{ $product->supplier->name }}</td>
                <td>{{ $product->currentStock() }}</td>
                <td>{{ $product->unit }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>部品在庫</h2>
    <table border="1" cellpadding="8">
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
                <td style="@if($isLowStock)color: red;@endif">{{ $part->currentStock() }}</td>
                <td>{{ $part->unit }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
</body>

</html>