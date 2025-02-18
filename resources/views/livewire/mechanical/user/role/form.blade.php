<div>
    <form class="mc-card" wire:submit.prevent="save">
        <div class="grid gap-y-5 gap-x-5  p-5">
            <x-select label="Grupos" wire:model.defer="state.role_id" >
                @foreach($response->roles as $itemRole)
                    <option value="{{$itemRole['id']}}">{{$itemRole['name']}}</option>
                @endforeach
            </x-select>
            <x-button size="md">Salvar</x-button>
        </div>
    </form>
</div>
