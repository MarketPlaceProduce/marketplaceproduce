@props(['value'])

<label {{ $attributes->merge(['class' => 'flex font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
