@props([
    'type' => 'text',
    'error' => null,
    'placeholder' => null,
    'label',
    'divClass' => '',
    'inputClass' => '',
    'subdomain' => false,
])
@php
$id = $error.'-'.rand(0,99999);

$errorClass = 'mc-form-text peer border-l-4 border-red-500';
$successClass = 'mc-form-text peer disabled:text-gray-500';

@endphp
<div x-data class="relative {{ $divClass }}">
    <label>
            <input
                type="{{$type}}"
                id="{{ $id }}"
                {{ $attributes->wire('model') }}
                placeholder="{{ $label }}"
                autocomplete="off"
                @error($error)
                    {{ $attributes->merge(['class' => $errorClass]) }}
                @else
                    {{ $attributes->merge(['class' => $successClass]) }}
                @enderror
            />
        <span class="mc-form-label-basic">{{ $label }}</span>
        @error($error)
            <small class="mc-form-error pl-2">{{ $message }}</small>
        @enderror
    </label>
</div>
