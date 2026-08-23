<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>仕入先一覧 | 在庫管理システム</title>
</head>

<body>
    <h1>仕入先一覧</h1>

    <p><a href="{{ route('suppliers.create') }}">新規登録</a></p>

    @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>仕入先名</th>
                <th>連絡先</th>
                <th>登録日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->id }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->contact_info }}</td>
                <td>{{ $supplier->created_at->format('Y/m/d') }}</td>
                <td>
                    <a href="{{ route('suppliers.edit', $supplier) }}">編集</a>
                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $suppliers->links() }}
</body>

</html>