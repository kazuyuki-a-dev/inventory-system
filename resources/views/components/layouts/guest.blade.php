@props(['title' => '在庫管理システム'])

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | 在庫管理システム</title>
    @include('partials.vite-assets')
</head>

<body class="flex min-h-screen items-center justify-center bg-gray-50 text-gray-900 antialiased">
    <div class="w-full max-w-sm px-4">
        <p class="mb-6 text-center text-xl font-semibold text-gray-900">在庫管理システム</p>

        <div class="card">
            <h1 class="mb-6 text-lg font-semibold text-gray-900">{{ $title }}</h1>
            {{ $slot }}
        </div>
    </div>
</body>

</html>
