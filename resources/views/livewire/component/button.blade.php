<div>
    <button wire:click.prevent='openModal("{{$component}}", {"id": null}, {{$level}})' class="ed-button-lg ed-button-lg-text ed-button-lg-icon ed-button-solid-primary py-1">
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
