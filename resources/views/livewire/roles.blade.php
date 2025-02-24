
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <button wire:click="create" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
                    Criar Role
                </button>

                @if (session()->has('message'))
                    <div class="bg-green-500 text-white p-2 rounded mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                <table class="w-full table-auto">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Nome</th>
                        <th class="px-4 py-2">Descrição</th>
                        <th class="px-4 py-2">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td class="border px-4 py-2">{{ $role->name }}</td>
                            <td class="border px-4 py-2">{{ $role->label }}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $role->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded">
                                    Editar
                                </button>
                                <button wire:click="delete({{ $role->id }})" class="bg-red-500 text-white px-4 py-2 rounded">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if($isOpen)
                    @include('livewire.roles-modal')
                @endif
            </div>
        </div>
    </div>
</div>

