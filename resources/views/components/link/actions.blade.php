@props([
    'label',
    'icon' => '',
    'color' => 'primary',
    'divComponentId' => '',
    'divComponentClass' => ''
])

@php
    $class = "peer z-[2] w-8 h-8 mc-button mc-button-solid-{$color} mc-button-sm-icon disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed"
@endphp
<div class="{{ $divComponentClass }}">
    <span class="relative inline-flex items-center">
        <a {{$attributes->merge(['class' => $class])}}>
            @if($icon)
                <span class="material-icons-round text-lg px-0.5">
                    {{ $icon }}
                </span>
            @else
                <img class="w-4 " src="https://time.appsolar.com.br/file/dfa190a6-9b65-4fe6-aad5-3a69d8acdd33">
            @endif
        </a>
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
