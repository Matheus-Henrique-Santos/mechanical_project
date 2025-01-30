<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Registrar Tenant</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="register">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nome da Empresa</label>
            <input type="text" id="name" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Endereço</label>
            <input type="text" id="address" wire:model="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Pessoa</label>
            <select id="type" wire:model="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="pf">Pessoa Física</option>
                <option value="pj">Pessoa Jurídica</option>
            </select>
            @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="document" class="block text-sm font-medium text-gray-700">CPF ou CNPJ</label>
            <input type="text" id="document" wire:model="document" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('document') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
            <input type="text" id="phone" wire:model="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="subdomain" class="block text-sm font-medium text-gray-700">Subdomínio</label>
            <input type="text" id="subdomain" wire:model="subdomain" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('subdomain') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
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
