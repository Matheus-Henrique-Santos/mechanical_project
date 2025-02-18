@props([
    'type' => 'text',
    'error' => null,
    'placeholder' => null,
    'label',
    'divClass' => '',
    'inputClass' => '',
    'inputMask' => null
])
@php
$id = $error.'-'.rand(0,99999);

$errorClass = 'mc-form-text peer border-l-4 border-red-500';
$successClass = 'mc-form-text peer disabled:text-gray-500';

@endphp
<div x-data class="relative {{ $divClass }}">
    <label>
        @if($inputMask)
            @if($inputMask !== 'money' && $inputMask !== 'decimal')
                <input
                    x-ref="input"
                    x-init="Inputmask('{{ $inputMask }}').mask($refs.input)"
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
            @elseif($inputMask == 'money')
                <input
                    x-ref="input"
                    x-init="VMasker($refs.input).maskMoney({
                        precision: 2,
                        separator: ',',
                        delimiter: '.',
                        unit: '',
                        suffixUnit: '',
                    })"
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
            @elseif($inputMask == 'decimal')
                <input
                    x-ref="input"
                    x-init="VMasker($refs.input).maskMoney({
                        separator: ',',
                        delimiter: '\u000D',
                        unit: '',
                        suffixUnit: '',
                    })"
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
            @endif
        @else
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
        @endif
        <span class="mc-form-label-basic">{{ $label }}</span>
        @error($error)
            <small class="mc-form-error">{{ $message }}</small>
        @enderror
    </label>
</div>
