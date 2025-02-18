@props([
    'error' => null,
    'label',
    'divClass' => '',
    'inputClass' => '',
])
@php
    $id = $error.'-'.rand(0,99999);
@endphp
<label class="mc-form-label-checkbox">
    <input
        type="checkbox"
        id="{{ $id }}"
        @error($error)
        {{ $attributes->merge(['class' => 'mc-form-checkbox border-red-500']) }}
        @else
        {{ $attributes->merge(['class' => 'mc-form-checkbox']) }}
        @enderror
        class="{{ $inputClass }}" />
    <span>{{ $label ?? null }}</span>
</label>
@error($error)
<small class="text-red-500">
    {{$message}}
</small>
@enderror

