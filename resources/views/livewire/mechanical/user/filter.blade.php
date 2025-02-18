<div class="pb-5">
    <form wire:submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-12 items-center gap-5">
            <div class="md:col-span-4">
                <x-input wire:model.defer="state.name" label="Nome" />
            </div>
            <div class="col-span-6">
                <div class="flex gap-x-5">
                    <x-button icon="search" size="md">
                        Buscar
                    </x-button>
                    <x-button wire:click="clearFilter" size="md" color="muted">
                        Limpar
                    </x-button>
                </div>
            </div>
        </div>
    </form>
</div>
