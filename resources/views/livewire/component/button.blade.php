<div>
    <button wire:click.prevent='openModal("{{$component}}", "{{ $event }}", {"id": null}, {{$level}})'>
        <span>
            {{$text}}
        </span>
        @if($icon)
            <span class="material-icons-round text-lg">
                {{ $icon }}
            </span>
        @endif
    </button>
</div>
