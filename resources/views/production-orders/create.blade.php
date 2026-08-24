<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>製造指示新規登録 | 在庫管理システム</title>
</head>

<body>
    <h1>製造指示新規登録</h1>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('production-orders.store') }}">
        @csrf

        <div>
            <label for="product_id">商品</label>
            <select id="product_id" name="product_id" required>
                <option value="">選択してください</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected(old('product_id')==$product->id)>
                    {{ $product->name }}(SKU: {{ $product->sku }})
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="quantity">製造数量</label>
            <input id="quantity" type="number" name="quantity" min="1" value="{{ old('quantity') }}" required>
        </div>

        <div>
            <label for="planned_date">予定日</label>
            <input id="planned_date" type="date" name="planned_date" value="{{ old('planned_date') }}">
        </div>

        <div>
            <button type="submit">登録</button>
        </div>
    </form>

    <p><a href="{{ route('production-orders.index') }}">一覧に戻る</a></p>
</body>

</html>