<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>カテゴリ新規登録 | 在庫管理システム</title>
</head>

<body>
    <h1>カテゴリ新規登録</h1>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div>
            <label for="name">カテゴリ名</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <button type="submit">登録</button>
        </div>
    </form>

    <p><a href="{{ route('categories.index') }}">一覧に戻る</a></p>
</body>

</html>