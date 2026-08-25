@props(['action', 'confirm' => '本当に削除しますか？', 'label' => '削除'])

<form action="{{ $action }}" method="POST" class="inline" onsubmit="return confirm('{{ $confirm }}');">
    @csrf
    @method('DELETE')
    <button type="submit" {{ $attributes->merge(['class' => 'btn btn-danger']) }}>{{ $label }}</button>
</form>
