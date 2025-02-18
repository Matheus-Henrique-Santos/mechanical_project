<div>
    <form class="mc-card" wire:submit.prevent="save">
        <div class="grid gap-y-5 gap-x-5  p-5">
            <h1 class="text-lg font-medium border-b-2">
                Permissões
            </h1>
            <div class="grid gap-y-5 gap-x-5  p-5">
                @foreach($response->groups as $itemGroup)
                    <p>{{$itemGroup['name']}}</p>
                    <ul>
                        @foreach($itemGroup->permissions as $permission)
                            <li><x-input.checkbox wire:model.defer="permissions.{{$permission['id']}}" :label="$permission['label']" /></li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
            <x-button size="md">Salvar</x-button>
        </div>
    </form>
</div>
