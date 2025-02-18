<div>
    <form class="mc-card" wire:submit.prevent="save">
        <h1 class="text-lg font-medium absolute top-2 left-8">
            {{$response->user ? 'Editar Usuário' : 'Cadastrar novo usuário'}}
        </h1>
        <div class="md:col-span-12">
            <h1 class="text-lg font-medium">
                Dados do Usuário
            </h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 items-start gap-y-5 gap-x-5 pt-2">
            <div class="md:col-span-8">
                <x-input label="Nome" title="Utilize somente letras" wire:model.defer="state.name" autocomplete="off" error="name"/>
            </div>
            <div class="md:col-span-4">
                <x-select label="Nível de acesso" wire:model.defer="state.role_id" error="role_id">
                    @foreach($response->roles as $itemRole)
                        <option value="{{$itemRole['id']}}">{{$itemRole['name']}}</option>
                    @endforeach
                </x-select>
            </div>
            <div class="md:col-span-4">
                <x-input label="Telefone" wire:model.defer="state.phone" input-mask="phone" error="phone" autocomplete="off" />
            </div>
            <div class="md:col-span-8">
               <x-input label="E-mail" wire:model.defer="state.email" autocomplete="off" error="email"/>
            </div>
            <div class="md:col-span-4">
                <x-input type="password" wire:model.defer="state.password" autocomplete="off" error="password" label="Senha"/>
            </div>
            <div class="md:col-span-4">
                <x-input type="password" wire:model.defer="state.confirm_password" autocomplete="off" error="confirm_password" label="Confirmar senha"/>
            </div>
            <div class="md:col-span-4">
                <x-select wire:model.defer="state.status" error="status" label="Status">
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </x-select>
            </div>
            @if(Auth::user()->tenant->scope == 'Comercial')
                <div class="md:col-span-4">
                    <x-input type="text" wire:model.defer="state.reev_token" autocomplete="off" error="reev_token" label="Reev token"/>
                </div>
            @endif
            <div class="md:col-span-12">
                <x-button size="md">{{$response->user ? 'Salvar' : 'Cadastrar'}}</x-button>
            </div>
        </div>
    </form>
</div>
