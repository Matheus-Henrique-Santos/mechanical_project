<div>
    <div x-data="{ sideModal: false }">
        <div class="fixed top-0 left-0 z-50 w-screen h-screen bg-black/15"
             x-cloak x-show="sideModal"
             x-on:open-side-modal.window="sideModal = true"
             x-on:close-side-modal.window="sideModal = false">

            <div
                class="fixed top-0 right-0 z-40 h-screen w-[700px] max-w-full shadow-2xl bg-gray-100 p-2 md:p-5 rounded-l-md overflow-y-scroll styled-scrollbar"
                x-cloak x-show="sideModal"
                x-transition:enter="transition origin-left ease-out duration-500"
                x-transition:enter-start="transform translate-x-full"
                x-transition:enter-end="transform translate-x-0"
                x-transition:leave="transition origin-right ease-out duration-500"
                x-transition:leave-start="transform translate-x-0"
                x-transition:leave-end="transform translate-x-full">

                <a x-on:click="sideModal = false" class="absolute top-0 right-0 m-2 cursor-pointer w-8 h-8  text-blue-500 font-bold text-lg rounded-full flex items-center justify-center">X</a>
                <div class="h-full">
                    @if($componentName)
                        @livewire($componentName, $params, key($uuid))
                    @endif
                </div>

            </div>

            <div x-on:click="sideModal = false" class="fixed top-0 left-0 z-30 w-screen h-screen"></div>

        </div>
    </div>
    <style>
        .styled-scrollbar::-webkit-scrollbar {
            width: 8px; /* Largura da barra de rolagem */
            height: 8px; /* Altura da barra de rolagem horizontal */
        }

        .styled-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1; /* Cor do trilho da barra de rolagem */
        }

        .styled-scrollbar::-webkit-scrollbar-thumb {
            background-color: #888; /* Cor do polegar da barra de rolagem */
            border-radius: 10px; /* Arredondamento do polegar da barra de rolagem */
        }

        .styled-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #555; /* Cor do polegar da barra de rolagem ao passar o mouse */
        }

        .styled-scrollbar {
            scrollbar-width: thin; /* Para Firefox */
            scrollbar-color: #888 #f1f1f1; /* Para Firefox */
        }

        .styled-scrollbar {
            -ms-overflow-style: none; /* Para Internet Explorer e Edge */
            scrollbar-width: thin; /* Para Firefox */
        }
    </style>
</div>
