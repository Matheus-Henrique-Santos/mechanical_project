<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Orçamentos</h1>
                @if(Auth::user()->role === 'mechanic')
                    <button
                        wire:click="createQuote"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Novo Orçamento
                    </button>
                @endif
            </div>

            <!-- Filters -->
            <div class="mt-6 md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4">
                    <div class="w-full lg:max-w-xs">
                        <label for="search" class="sr-only">Buscar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                wire:model.debounce.300ms="search"
                                id="search"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Buscar orçamentos..."
                                type="search"
                            >
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <select
                            wire:model="statusFilter"
                            class="block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        >
                            <option value="all">Todos os Status</option>
                            <option value="draft">Rascunho</option>
                            <option value="pending_store">Aguardando Loja</option>
                            <option value="pending_client">Aguardando Cliente</option>
                            <option value="approved">Aprovado</option>
                            <option value="rejected">Rejeitado</option>
                            <option value="completed">Concluído</option>
                        </select>

                        <input
                            wire:model="dateFilter"
                            type="date"
                            class="block pl-3 pr-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        >

                        @if(isset($dateFilter))
                            <button
                                wire:click="$set('dateFilter', '')"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Limpar Data
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            @if($isCreating || $isEditing)
                <!-- Quote Form -->
                <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $isEditing ? 'Editar Orçamento' : 'Novo Orçamento' }}
                        </h3>

                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- Client Selection -->
                            <div class="sm:col-span-3">
                                <label for="clientId" class="block text-sm font-medium text-gray-700">Cliente</label>
                                <div class="mt-1">
                                    <select
                                        wire:model="clientId"
                                        id="clientId"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    >
                                        <option value="">Selecione o Cliente</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('clientId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="sm:col-span-3">
                                <x-input wire:model.defer="title" error="title" label="Título" />
                            </div>

                            <!-- Description -->
                            <div class="sm:col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                                <div class="mt-1">
                                    <textarea
                                        wire:model.defer="description"
                                        id="description"
                                        rows="3"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Descreva o orçamento"
                                    ></textarea>
                                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Valid Until -->
                            <div class="sm:col-span-3">
                                <label for="validUntil" class="block text-sm font-medium text-gray-700">Válido Até</label>
                                <div class="mt-1">
                                    <input
                                        type="date"
                                        wire:model.defer="validUntil"
                                        id="validUntil"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                    >
                                    @error('validUntil') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <div class="flex justify-between items-center">
                                    <h4 class="text-base font-medium text-gray-900">Itens do Orçamento</h4>
                                    <button
                                        wire:click="addItem"
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Adicionar Item
                                    </button>
                                </div>

                                @if($showItemForm)
                                    <!-- Item Form -->
                                    <div class="mt-4 p-4 bg-gray-50 rounded-md">
                                        <h5 class="text-sm font-medium text-gray-700 mb-4">
                                            {{ $editingItemIndex !== null ? 'Editar Item' : 'Novo Item' }}
                                        </h5>

                                        <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-2">
                                                <label for="itemType" class="block text-sm font-medium text-gray-700">Tipo</label>
                                                <div class="mt-1">
                                                    <select
                                                        wire:model="itemType"
                                                        id="itemType"
                                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                                    >
                                                        <option value="product">Produto</option>
                                                        <option value="service">Serviço</option>
                                                    </select>
                                                </div>
                                            </div>

                                            @if($itemType === 'product')
                                                <div class="sm:col-span-4">
                                                    <label for="searchProduct" class="block text-sm font-medium text-gray-700">Buscar Produto</label>
                                                    <div class="mt-1 flex">
                                                        <div class="relative flex-grow">
                                                            <input
                                                                type="text"
                                                                wire:model.debounce.300ms="searchProduct"
                                                                id="searchProduct"
                                                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                                                placeholder="Digite para buscar produtos"
                                                            >
                                                            @if(count($availableProducts) > 0)
                                                                <div class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md overflow-auto max-h-60">
                                                                    <ul class="divide-y divide-gray-200">
                                                                        @foreach($availableProducts as $product)
                                                                            <li
                                                                                wire:click="$emit('productSelected', {id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ $product->price }}})"
                                                                                class="px-4 py-2 hover:bg-indigo-50 cursor-pointer"
                                                                            >
                                                                                <div class="flex justify-between">
                                                                                    <span>{{ $product->name }}</span>
                                                                                    <span class="text-gray-500">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                                                                                </div>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <label for="storeId" class="block text-sm font-medium text-gray-700">Loja</label>
                                                    <div class="mt-1">
                                                        <select
                                                            wire:model="storeId"
                                                            id="storeId"
                                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                                        >
                                                            <option value="">Selecione a Loja</option>
                                                            @foreach($stores as $store)
                                                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('storeId') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            @else
                                                <div class="sm:col-span-4">
                                                    <label for="searchService" class="block text-sm font-medium text-gray-700">Buscar Serviço</label>
                                                    <div class="mt-1">
                                                        <select
                                                            wire:model="serviceId"
                                                            id="serviceId"
                                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                                        >
                                                            <option value="">Selecione o Serviço</option>
                                                            @foreach($availableServices as $service)
                                                                <option value="{{ $service->id }}">{{ $service->name }} - R$ {{ number_format($service->price, 2, ',', '.') }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="sm:col-span-3">
                                                <x-input wire:model.defer="itemName" error="itemName" label="Nome do Item" />
                                            </div>

                                            <div class="sm:col-span-1">
                                                <x-input wire:model.defer="itemQuantity" error="itemQuantity" label="Quantidade" type="number" min="1" />
                                            </div>

                                            <div class="sm:col-span-2">
                                                <x-input wire:model.defer="itemPrice" error="itemPrice" label="Preço Unitário" type="number" step="0.01" />
                                            </div>

                                            <div class="sm:col-span-6 flex justify-end space-x-3">
                                                <button
                                                    wire:click="cancelItemForm"
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                >
                                                    Cancelar
                                                </button>

                                                <button
                                                    wire:click="saveItem"
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                >
                                                    {{ $editingItemIndex !== null ? 'Atualizar' : 'Adicionar' }} Item
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Items List -->
                                <div class="mt-4">
                                    @if(count($items) > 0)
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loja</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço Unit.</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($items as $index => $item)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $item['type'] === 'product' ? 'Produto' : 'Serviço' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ $item['name'] }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $item['store_name'] ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $item['quantity'] }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            R$ {{ number_format($item['unit_price'], 2, ',', '.') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            R$ {{ number_format($item['total_price'], 2, ',', '.') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @if(isset($item['status']))
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                        {{ $item['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                                        {{ $item['status'] === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                                                        {{ $item['status'] === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                                                    ">
                                                                        {{ $item['status'] === 'pending' ? 'Pendente' : ($item['status'] === 'approved' ? 'Aprovado' : 'Rejeitado') }}
                                                                    </span>
                                                            @else
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                        Novo
                                                                    </span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                            <div class="flex space-x-2">
                                                                <button
                                                                    wire:click="editItem({{ $index }})"
                                                                    class="text-indigo-600 hover:text-indigo-900"
                                                                >
                                                                    Editar
                                                                </button>
                                                                <button
                                                                    wire:click="removeItem({{ $index }})"
                                                                    class="text-red-600 hover:text-red-900"
                                                                >
                                                                    Remover
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <!-- Total Row -->
                                                <tr class="bg-gray-50">
                                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                                        Total:
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                        R$ {{ number_format(collect($items)->sum('total_price'), 2, ',', '.') }}
                                                    </td>
                                                    <td colspan="2"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-sm text-center py-4">
                                            Nenhum item adicionado ao orçamento. Clique em "Adicionar Item" para começar.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button
                                wire:click="cancelEdit"
                                type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Cancelar
                            </button>

                            <button
                                wire:click="saveQuote"
                                type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Salvar Orçamento
                            </button>

                            @if($isEditing && $quoteId)
                                <button
                                    wire:click="submitForApproval"
                                    type="button"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                >
                                    Enviar para Aprovação
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Quotes List -->
                <div class="mt-6 flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Título
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Cliente / Mecânico
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Data
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ações
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($quotes as $quote)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $quote->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $quote->title }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    @if(Auth::user()->role !== 'client')
                                                        <div class="text-sm font-medium text-gray-900">{{ $quote->client->name }}</div>
                                                        <div class="text-xs text-gray-500">Cliente</div>
                                                    @endif

                                                    @if(Auth::user()->role !== 'mechanic')
                                                        <div class="text-sm font-medium text-gray-900 {{ Auth::user()->role !== 'client' ? 'mt-1' : '' }}">{{ $quote->mechanic->name }}</div>
                                                        <div class="text-xs text-gray-500">Mecânico</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $quote->created_at->format('d/m/Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                R$ {{ number_format($quote->total_amount, 2, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $quote->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                                        {{ $quote->status === 'pending_store' ? 'bg-blue-100 text-blue-800' : '' }}
                                                        {{ $quote->status === 'pending_client' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $quote->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ $quote->status === 'rejected' ? 'Rejeitado' : '' }}
                                                        {{ $quote->status === 'completed' ? 'Concluído' : '' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a
                                                        href="{{ route('quotes.show', $quote) }}"
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        Visualizar
                                                    </a>

                                                    @if(Auth::user()->role === 'mechanic' && in_array($quote->status, ['draft', 'rejected']))
                                                        <button
                                                            wire:click="editQuote({{ $quote->id }})"
                                                            class="text-blue-600 hover:text-blue-900"
                                                        >
                                                            Editar
                                                        </button>
                                                    @endif

                                                    @if(Auth::user()->role === 'store' && $quote->status === 'pending_store')
                                                        <button
                                                            wire:click="openMessageModal({{ $quote->mechanic_id }}, '{{ $quote->mechanic->name }}')"
                                                            class="text-green-600 hover:text-green-900"
                                                        >
                                                            Mensagem
                                                        </button>
                                                    @endif

                                                    @if(Auth::user()->role === 'client' && $quote->status === 'pending_client')
                                                        <button
                                                            wire:click="approveQuote({{ $quote->id }})"
                                                            class="text-green-600 hover:text-green-900"
                                                        >
                                                            Aprovar
                                                        </button>

                                                        <button
                                                            wire:click="rejectQuote({{ $quote->id }})"
                                                            class="text-red-600 hover:text-red-900"
                                                        >
                                                            Rejeitar
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                Nenhum orçamento encontrado.
                                                @if(Auth::user()->role === 'mechanic')
                                                    Clique em "Novo Orçamento" para criar um.
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    {{ $quotes->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Message Modal -->
    @if($showMessageModal)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Enviar Mensagem para {{ $messageRecipientName }}
                        </h3>

                        <div class="mt-4">
                            <label for="messageContent" class="block text-sm font-medium text-gray-700">Mensagem</label>
                            <div class="mt-1">
                            <textarea
                                wire:model.defer="messageContent"
                                id="messageContent"
                                rows="4"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Digite sua mensagem..."
                            ></textarea>
                                @error('messageContent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            wire:click="sendMessage"
                            type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Enviar
                        </button>
                        <button
                            wire:click="$set('showMessageModal', false)"
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
