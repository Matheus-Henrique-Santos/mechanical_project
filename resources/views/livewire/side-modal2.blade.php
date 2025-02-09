<div>
    <div x-data="{ sideModal2: false }">
        <div class="fixed top-0 left-0 z-50 w-screen h-screen bg-black/15"
             x-cloak x-show="sideModal2"
             x-on:open-side-modal2.window="sideModal2 = true"
             x-on:close-side-modal2.window="sideModal2 = false">

            <div class="fixed top-0 right-0 z-40 h-screen w-[500px] max-w-full shadow-2xl bg-gray-100 p-2 md:p-5 rounded-l-2xl"
                 x-cloak x-show="sideModal2"
                 x-transition:enter="transition origin-left ease-out duration-500"
                 x-transition:enter-start="transform translate-x-full"
                 x-transition:enter-end="transform translate-x-0"
                 x-transition:leave="transition origin-right ease-out duration-500"
                 x-transition:leave-start="transform translate-x-0"
                 x-transition:leave-end="transform translate-x-full">

                <a x-on:click="sideModal2 = ! sideModal2" class="absolute top-0 right-0 m-2 cursor-pointer w-8 h-8 text-blue-500 font-bold text-lg rounded-full flex items-center justify-center">X</a>
                @if($componentName)
                    @livewire($componentName, $params, key($uuid))
                @endif

            </div>

            <div x-on:click="sideModal2 = ! sideModal2" class="fixed top-0 left-0 z-30 w-screen h-screen"></div>

        </div>
    </div>
</div>
