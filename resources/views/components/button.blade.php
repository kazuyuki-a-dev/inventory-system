@props(['variant' => 'primary', 'href' => null, 'type' => 'submit'])

@php
    $variantClass = match ($variant) {
        'secondary' => 'btn-secondary',
        'danger' => 'btn-danger',
        default => 'btn-primary',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "btn $variantClass"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "btn $variantClass"]) }}>
        {{ $slot }}
    </button>
@endif
