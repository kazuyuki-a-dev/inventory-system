<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>部品編集 | 在庫管理システム</title>
</head>

<body>
    <h1>部品編集</h1>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('parts.update', $part) }}">
        @csrf
        @method('PUT')

        <div>
            <label for="supplier_id">仕入先</label>
            <select id="supplier_id" name="supplier_id" required>
                <option value="">選択してください</option>
                @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected(old('supplier_id', $part->supplier_id) == $supplier->id)>
                    {{ $supplier->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="sku">SKU</label>
            <input id="sku" type="text" name="sku" value="{{ old('sku', $part->sku) }}" required>
        </div>

        <div>
            <label for="name">部品名</label>
            <input id="name" type="text" name="name" value="{{ old('name', $part->name) }}" required>
        </div>

        <div>
            <label for="unit">単位</label>
            <input id="unit" type="text" name="unit" value="{{ old('unit', $part->unit) }}" required>
        </div>

        <div>
            <label for="price">単価</label>
            <input id="price" type="number" name="price" step="0.01" value="{{ old('price', $part->price) }}" required>
        </div>

        <div>
            <button type="submit">更新</button>
        </div>
    </form>

    <p><a href="{{ route('parts.index') }}">一覧に戻る</a></p>
</body>

</html>