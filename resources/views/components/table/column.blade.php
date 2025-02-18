@props([
    'column' => null
])
<div>
    <div {{ $attributes->merge(['class' => 'flex items-center cursor-pointer']) }}>
        {{ $slot }}
        @if($column)
            <span x-cloak x-show="order['order'] === 'ASC' && order['column'] === '{{ $column }}'" class="material-icons-round">
                expand_less
            </span>
            <span x-cloak x-show="order['order'] === 'DESC' && order['column'] === '{{ $column }}'" class="material-icons-round">
                keyboard_arrow_down
            </span>
            <span x-cloak x-show=" order['column'] !== '{{ $column }}' || order['order'] === null" class="text-gray-300 material-icons-round">
                unfold_more
            </span>
        @endif
    </div>
</div>
