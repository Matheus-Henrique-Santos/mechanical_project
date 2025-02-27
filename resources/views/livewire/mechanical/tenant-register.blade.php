<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Registrar Tenant</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="register">
        <div class="mb-4">
            <div class="md:col-span-4">
                <x-input wire:model.defer="name" error="name" label="Nome" />
            </div>
        </div>

        <div class="mb-4">
            <div class="md:col-span-4">
                <x-input wire:model.defer="email" error="email" label="Email" />
            </div>
        </div>

        <div class="mb-4">
            <div class="md:col-span-4">
                <x-input wire:model.defer="address" error="address" label="Endereço" />
            </div>
        </div>

{{--        <div class="mb-4">--}}
{{--            <x-select wire:model="type" error="uf" label="Tipo">--}}
{{--                <option value="pf">Pessoa Física</option>--}}
{{--                <option value="pj">Pessoa Jurídica</option>--}}
{{--            </x-select>--}}
{{--            @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror--}}
{{--        </div>--}}

        <div class="mb-4">
            <div class="md:col-span-4">
                <x-input wire:model.defer="document" error="document" label="CNPJ" />
            </div>
        </div>

        <div class="mb-4">
            <div class="md:col-span-4">
                <x-input wire:model.defer="phone" error="phone" label="Telefone" />
            </div>
        </div>

        <div class="mb-4">
            <div class="md:col-span-4">
                <x-input wire:model.defer="subdomain" error="subdomain" label="Subdomínio" />
            </div>
        </div>

        <div class="mb-4">
            <label for="logo" class="block text-sm font-medium text-gray-700">Logotipo</label>
            <input type="file" id="logo" wire:model="logo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('logo') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

            @if (isset($logo))
                <p class="mt-2 text-sm text-gray-500">Pré-visualização:</p>
                <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="h-16 mt-2">
            @endif
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow-sm hover:bg-blue-600">Registrar</button>
    </form>
</div>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            $('#document').on('input', function () {
                const type = $('#type').val();
                $(this).mask(type === 'pj' ? '00.000.000/0000-00' : '000.000.000-00', { reverse: true });
            });

            $('#type').on('change', function () {
                const documentInput = $('#document');
                documentInput.val('');
                documentInput.mask(this.value === 'pj' ? '00.000.000/0000-00' : '000.000.000-00', { reverse: true });
            });
        });
    </script>
@endpush
