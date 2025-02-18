@props([
'label',
'icon' => '',
'color' => 'primary',
'divComponentId' => '',
'divComponentClass' => ''
])

@php
    $class = "peer z-[2] w-6 h-6 mc-button mc-button-solid-{$color} mc-button-sm-icon disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed"
@endphp
<div id="{{ $divComponentId }}" class="{{ $divComponentClass }}">
    <span class="relative inline-flex items-center">
        <button {{ $attributes->merge(['class' => $class])}}>
            <span class="material-icons-round text-lg px-0.5">
                {{ $icon }}
            </span>
        </button>
       <div class="absolute -top-0 z-[2] px-1.5 py-1 -mt-1 text-[10px] leading-none text-white right-0 -translate-y-full bg-gray-900 rounded-lg shadow-lg hidden peer-hover:block">
            {{ $label }}
       </div>
       <svg
           class="absolute -top-1 z-[1] w-6 h-6 text-gray-900 -translate-x-0.5 -translate-y-2 fill-current stroke-current hidden peer-hover:block"
           width="4"
           height="4"
       >
            <rect x="12" y="-10" width="8" height="8" transform="rotate(45)"/>
       </svg>
    </span>
</div>
