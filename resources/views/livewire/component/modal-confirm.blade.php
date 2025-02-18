<div x-data="{confirmationModal: @entangle('show') }">
    <div x-cloak @if($closeModal) @click.outside="confirmationModal = true" @endif x-show="confirmationModal" class="fixed z-60 inset-0 overflow-y-auto flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            :class="{'ease-out duration-300 opacity-100 visible': confirmationModal === true, 'ease-in duration-300 opacity-0 invisible': confirmationModal === false}"
            @click="confirmationModal = @if($closeModal) false @else true @endif"
            aria-hidden="true"
        ></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl  transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            :class="{'ease-out duration-300 opacity-100 translate-y-0 sm:scale-100 visible': confirmationModal === true, 'ease-in duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 invisible': confirmationModal === false}"
        >
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex text-red-400 items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Heroicon name: outline/exclamation -->
                        <span class="material-icons-round">
                            {{ $icon }}
                        </span>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">{{ $title }}</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">{!! $message !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                @if(!is_null($withoutQuantity) && $withoutQuantity == 'Sim')
                    <button type="button" wire:click="close" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Fechar
                    </button>
                @else
                    @if(!$isSafari)
                        <button id="confirmButtonText" onclick="ClickConfirmButtonText();" wire:click="$emit('{{$eventName}}', {{$eventParam}})" type="button" class="disabled:bg-slate-400 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 @if($colorButton == 'red') bg-red-600 hover:bg-red-700 focus:ring-red-500 @else bg-green-600 hover:bg-green-700 focus:ring-green-500 @endif text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $confirmButtonText }}
                        </button>
                    @else
                        <a id="confirmButtonText" wire:click="close(2)" href="{{$proposalUrl}}" target="_blank" class="disabled:bg-slate-400 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Gerar
                        </a>
                    @endif
                    @if($cancelButtonText)
                        <button type="button" wire:click="close(2)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $cancelButtonText }}
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    const botton = document.getElementById('confirmButtonText')
    botton.removeAttribute("disabled")
    botton.classList.remove("block")

    function ClickConfirmButtonText() {
        botton.setAttribute("disabled",'true')
        botton.classList.add("block")
    }
</script>
