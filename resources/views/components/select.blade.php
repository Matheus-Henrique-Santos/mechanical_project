@props([
    'label',
    'error' => null,
    'divClass' => '',
    'option' => null
])
<div x-data="{ selectedOption: @entangle($attributes->wire('model')->value) }" class="{{ $divClass }}">
    <label class="relative ed-form-select">
        <select {{$attributes->wire('model')}} x-model="selectedOption" class="ed-form-select-input peer @error($error) border-l-4 border-red-500 @enderror">
            @if(!$option)
                <option value="" disabled selected class="hidden"></option>
            @endif
            {{$slot}}
        </select>

        <span
            class="mc-form-label-select"
            :class="{'text-sm text-gray-400 top-2 left-4': selectedOption === ''}"
        >
            {{$label}}
        </span>
        <span class="material-symbols-rounded absolute right-0 top-2 -z-[1] select-none text-gray-400">
            expand_more
        </span>
    </label>
    @error($error)
        <small class="mc-form-error"> {{ $message }} </small>
    @enderror
</div>
