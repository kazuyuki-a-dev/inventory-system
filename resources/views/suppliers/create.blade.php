<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>仕入先新規登録 | 在庫管理システム</title>
</head>

<body>
    <h1>仕入先新規登録</h1>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('suppliers.store') }}">
        @csrf

        <div>
            <label for="name">仕入先名</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="contact_info">連絡先</label>
            <input id="contact_info" type="text" name="contact_info" value="{{ old('contact_info') }}">
        </div>

        <div>
            <button type="submit">登録</button>
        </div>
    </form>

    <p><a href="{{ route('suppliers.index') }}">一覧に戻る</a></p>
</body>

</html>