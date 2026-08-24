<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>商品一覧 | 在庫管理システム</title>
</head>

<body>
    <h1>商品一覧</h1>

    <p><a href="{{ route('products.create') }}">新規登録</a></p>

    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>商品名</th>
                <th>カテゴリ</th>
                <th>仕入先</th>
                <th>単価</th>
                <th>単位</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->supplier->name }}</td>
                <td>{{ number_format($product->price) }}円</td>
                <td>{{ $product->unit }}</td>
                <td>
                    <a href="{{ route('products.edit', $product) }}">編集</a>
                    <a href="{{ route('products.parts.index', $product) }}">部品表</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</body>

</html>