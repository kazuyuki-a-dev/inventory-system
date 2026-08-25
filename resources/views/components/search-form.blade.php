@props(['placeholder' => '検索'])

<form method="GET" class="mb-4 flex items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder }}" class="form-input max-w-xs">
    <button type="submit" class="btn btn-secondary">検索</button>
    @if (request('search'))
        <a href="{{ url()->current() }}" class="text-sm text-gray-600 hover:underline">クリア</a>
    @endif
</form>
