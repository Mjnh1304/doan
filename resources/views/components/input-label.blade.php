@props(['value'])

<label {{ $attributes->merge([
    'class' => 'block font-semibold text-sm text-blue-700'
]) }}>
    {{ $value ?? $slot }}
</label>
