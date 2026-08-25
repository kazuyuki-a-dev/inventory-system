@props(['name', 'label'])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}" {{ $attributes->merge(['class' => 'form-select']) }}>
        {{ $slot }}
    </select>
</div>
