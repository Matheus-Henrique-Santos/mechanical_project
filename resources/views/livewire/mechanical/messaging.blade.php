<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-4">Messages</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Contacts Sidebar -->
                <div class="md:col-span-1 bg-white rounded-lg shadow">
                    <div class="p-4 border-b">
                        <div class="relative">
                            <input
                                type="text"
                                wire:model.debounce.300ms="search"
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Search contacts..."
                            >
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-y-auto h-96">
                        @forelse($contacts as $contact)
                            <div
                                wire:click="selectContact({{ $contact->id }})"
                                class="p-4 border-b hover:bg-gray-50 cursor-pointer {{ $selectedContact && $selectedContact->id === $contact->id ? 'bg-indigo-50' : '' }}"
                            >
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                            <span class="text-white font-medium">{{ substr($contact->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $contact->name }}
                                            </p>
                                            @if(isset($unreadMessages[$contact->id]) && $unreadMessages[$contact->id] > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $unreadMessages[$contact->id] }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            {{ $contact->role === 'mechanic' ? 'Mechanic' : ($contact->role === 'store' ? 'Store' : 'Client') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">
                                No contacts found.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Conversation Area -->
                <div class="md:col-span-2 bg-white rounded-lg shadow flex flex-col h-128">
                    @if($selectedContact)
                        <!-- Header -->
                        <div class="p-4 border-b flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                        <span class="text-white font-medium">{{ substr($selectedContact->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $selectedContact->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $selectedContact->role === 'mechanic' ? 'Mechanic' : ($selectedContact->role === 'store' ? 'Store' : 'Client') }}
                                    </p>
                                </div>
                            </div>

                            @if($quotes->count() > 0)
                                <div>
                                    <select
                                        wire:model="quoteFilter"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                    >
                                        <option value="">All Messages</option>
                                        @foreach($quotes as $quote)
                                            <option value="{{ $quote->id }}">Quote #{{ $quote->id }} - {{ $quote->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        @if($selectedQuote)
                            <div class="p-3 bg-indigo-50 text-xs text-indigo-700 border-b">
                                <div class="flex justify-between items-center">
                                    <span>Viewing messages for Quote #{{ $selectedQuote->id }} - {{ $selectedQuote->title }}</span>
                                    <button
                                        wire:click="$set('quoteFilter', '')"
                                        class="text-indigo-600 hover:text-indigo-900 text-xs font-medium"
                                    >
                                        Clear Filter
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Messages List -->
                        <div class="flex-1 p-4 overflow-y-auto space-y-4" id="conversation">
                            @forelse($currentConversation as $message)
                                <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="{{ $message->sender_id === Auth::id() ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }} rounded-lg px-4 py-2 max-w-xs sm:max-w-md">
                                        <p class="text-sm">{{ $message->content }}</p>
                                        <p class="text-xs text-gray-500 mt-1 text-right">
                                            {{ $message->created_at->format('M d, H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="flex justify-center items-center h-full">
                                    <p class="text-gray-500 text-center">
                                        No messages yet. Start the conversation!
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Message Input -->
                        <div class="p-4 border-t">
                            <form wire:submit.prevent="sendMessage">
                                <div class="flex items-center">
                                    <input
                                        type="text"
                                        wire:model.defer="messageContent"
                                        class="flex-1 border border-gray-300 rounded-md shadow-sm py-2 px-4 block w-full focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Type your message..."
                                    >
                                    <button
                                        type="submit"
                                        class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="flex-1 flex justify-center items-center">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No conversation selected</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Select a contact to start messaging.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', (message, component) => {
                if (component.fingerprint.name === 'messaging') {
                    const container = document.getElementById('conversation');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }
            });
        });
    </script>
</div>
