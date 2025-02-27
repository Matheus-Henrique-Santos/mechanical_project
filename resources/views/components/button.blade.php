@props([
    'color' => 'primary',
    'outline' => false,
    'size' => 'sm',
    'icon' => null
])

@php
    $outline = $outline ? 'outline' : 'solid';

    $classIconPadding = $size !== 'lg' ? 'pl-2 pr-1.5' : '';
    $classIcon = $icon ? "mc-button-{$size}-icon" : '';

    $class = "mc-button-{$outline}-{$color} mc-button-{$size} mc-button-{$size}-text {$classIcon} {$classIconPadding}  disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed"
@endphp

<button  {{$attributes->merge(['class' => $class])}}>
        <span>
            {{$slot}}
        </span>
    @if(isset($icon))
        <span class="material-icons-round text-lg leading-none px-0.5">
                {{ $icon }}
        </span>
    @endif
</button>
