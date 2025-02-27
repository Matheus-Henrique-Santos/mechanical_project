<x-app-layout>
    <div class="flex items-end justify-between pb-5 w-full">
        <h1 class="mc-title-external">
            Usuários
        </h1>
        <livewire:component.button text="Criar Usuário" component="mechanical.user.form" class-list="w-full md:w-32 text-center cursor-pointer block px-2 py-1 text-xs bg-blue-black text-white rounded hover:bg-opacity-50 font-bold active:scale-[0.99]"/>
    </div>
    <div class="mc-card">
        <livewire:mechanical.user.filter />
        <livewire:mechanical.user.table />
    </div>
</x-app-layout>
