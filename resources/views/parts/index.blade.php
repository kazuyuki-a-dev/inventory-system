<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>部品一覧 | 在庫管理システム</title>
</head>

<body>
    <h1>部品一覧</h1>

    <p><a href="{{ route('parts.create') }}">新規登録</a></p>

    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>部品名</th>
                <th>仕入先</th>
                <th>単価</th>
                <th>単位</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parts as $part)
            <tr>
                <td>{{ $part->id }}</td>
                <td>{{ $part->sku }}</td>
                <td>{{ $part->name }}</td>
                <td>{{ $part->supplier->name }}</td>
                <td>{{ number_format($part->price) }}円</td>
                <td>{{ $part->unit }}</td>
                <td>
                    <a href="{{ route('parts.edit', $part) }}">編集</a>
                    <form action="{{ route('parts.destroy', $part) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $parts->links() }}
</body>

</html>