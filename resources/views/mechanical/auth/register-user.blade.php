<x-app-layout>
    <div class="flex items-end justify-between pb-5 w-full">
        <h1 class="mc-title-external">
            Usuários
        </h1>
        <livewire:component.button text="Cadastrar" icon="add" component="mechanical.user.form"/>
    </div>
    <div class="mc-card">
        <livewire:mechanical.user.filter />
        <livewire:mechanical.user.table />
    </div>
</x-app-layout>
