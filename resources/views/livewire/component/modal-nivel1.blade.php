<div>
    <div x-data="{sideModal: @entangle('show')}">
        <div
            x-show="sideModal"
            class="w-full h-full bg-gray-800/40 dark:bg-gray-200/40 top-0 z-30 fixed"
            @click="sideModal = false"
        ></div>
        <div
            class="w-full lg:w-[900px] top-0 z-30 fixed duration-500 ease-in-out"
            :class="{'right-0 visible': sideModal === true, '-right-[840px] invisible': sideModal === false}"
        >
            <div class="w-full bg-gray-100 dark:bg-gray-800 dark:text-white h-screen absolute shadow-2xl overflow-y-auto py-4">
                <div class="relative py-4">
                    <div class="absolute top-0 right-6 -top-1 p-[5px]">
                        <span
                            class="material-icons-round text-gray-700 dark:text-white text-2xl cursor-pointer "
                            @click="sideModal = false"
                        >
                            cancel
                        </span>
                    </div>
                    <div class="p-8">

                    @if($show)
                            @livewire($component, $params)
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function myFunction(url) {
            navigator.clipboard.writeText(url);
        }
    </script>
</div>
