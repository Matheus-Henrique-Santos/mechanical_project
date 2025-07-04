<div>
    <x-table>
        <thead>
        <tr x-data="{order:@entangle('order')}">
            <th>
                <x-table.column class="justify-start" column="name">Nome</x-table.column>
            </th>
            <th>
                <x-table.column class="justify-start" column="email">E-mail</x-table.column>
            </th>
            <th>
                <x-table.column class="justify-center" column="role_id">Nível de acesso</x-table.column>
            </th>
            <th>
                <x-table.column class="justify-center" column="status">Status</x-table.column>
            </th>
            <th class="w-2/12">
                Ações
            </th>
        </tr>
        </thead>
        <tbody>
{{--        @foreach($response->users as $itemUser)--}}
            <tr>
                <td>
{{--                    {{$itemUser['name']}}--}}
                </td>
                <td>
{{--                    {{$itemUser['email']}}--}}
                </td>
                <td class="text-center">
                    {{ 'Sem Função Atribuida'}}
                </td>
                <td>
                    <div class="flex gap-x-2 justify-center text-center">
{{--                        <span class="{{$itemUser['status'] == 'Ativo' ? 'ed-status-success' : 'ed-status-danger'}}">--}}
{{--                        </span>--}}
{{--                        <p>{{$itemUser['status']}}</p>--}}
                    </div>
                </td>
                <td>
                    <div class="flex items-center justify-center gap-1">
                        <x-button.actions
                            label="Editar"
                            icon="edit"
                            color="primary"
{{--                            wire:click="openModal('vendor.user.form',{'id': {{ $itemUser['id'] }} })" --}}
                        />
                    </div>
                </td>
            </tr>
{{--        @endforeach--}}
        </tbody>
    </x-table>
    <div class="flex flex-col lg:flex-row gap-y-5 justify-between mt-4">
        <div class="flex items-end gap-x-2 text-xs w-full">
            <p>Mostrando</p>
{{--            <p class="w-full"> itens de {{ $response->users->total() }}</p>--}}
        </div>
        <div>
{{--            {{ $response->users->onEachSide(2)->links() }}--}}
        </div>
    </div>
</div>
