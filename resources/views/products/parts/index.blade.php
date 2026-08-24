<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }}の部品表(BOM) | 在庫管理システム</title>
</head>

<body>
    <h1>{{ $product->name }}(SKU: {{ $product->sku }})の部品表</h1>

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

    <h2>必要な部品一覧</h2>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>部品SKU</th>
                <th>部品名</th>
                <th>必要数</th>
                <th>単位</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($product->parts as $part)
            <tr>
                <td>{{ $part->sku }}</td>
                <td>{{ $part->name }}</td>
                <td>
                    <form action="{{ route('products.parts.update', [$product, $part]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity_required" value="{{ $part->pivot->quantity_required }}" min="1" style="width: 60px;">
                        <button type="submit">更新</button>
                    </form>
                </td>
                <td>{{ $part->unit }}</td>
                <td>
                    <form action="{{ route('products.parts.destroy', [$product, $part]) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">まだ部品が割り当てられていません。</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h2>部品を追加</h2>

    @if ($availableParts->isEmpty())
    <p>追加できる部品がありません(すべて割り当て済みです)。</p>
    @else
    <form action="{{ route('products.parts.store', $product) }}" method="POST">
        @csrf

        <label for="part_id">部品</label>
        <select id="part_id" name="part_id" required>
            <option value="">選択してください</option>
            @foreach ($availableParts as $part)
            <option value="{{ $part->id }}">{{ $part->name }}(SKU: {{ $part->sku }})</option>
            @endforeach
        </select>

        <label for="quantity_required">必要数</label>
        <input id="quantity_required" type="number" name="quantity_required" min="1" value="1" required>

        <button type="submit">追加</button>
    </form>
    @endif

    <p><a href="{{ route('products.index') }}">商品一覧に戻る</a></p>
</body>

</html>