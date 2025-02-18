<div>
    <div x-data="{centerModal: @entangle('show') }">
        <div
            x-cloak
            x-show="centerModal"
            class="w-full h-full bg-gray-800/40 dark:bg-gray-200/40 top-0 z-30 fixed"
            :class="{'ease-out duration-300 opacity-100 visible': centerModal === true, 'ease-in duration-300 opacity-0 invisible': centerModal === false}"
        ></div>


        <div
            x-cloak x-show="centerModal"

            class="fixed top-0 z-60 flex items-center justify-center min-h-screen w-screen"
        >
            <div
                @click.outside="centerModal = false"
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-auto shadow-xl transition-all sm:my-8 sm:align-middle md:w-1/3"
                :class="{'ease-out duration-300 opacity-100 translate-y-0 sm:scale-100 visible': centerModal === true, 'ease-in duration-300 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 invisible': centerModal === false}"
            >
                @if($show)
                    @livewire($component, $params)
                @endif

                @if(!$form)
                    <div class="bg-gray-50 px-4 py-3 flex justify-end">
                        <x-button type="button" wire:click="close()">
                            Fechar
                        </x-button>
                    </div>
                @endif
            </div>
            @if($form)
                <p class="absolute top-[80%] bg-black opacity-80 text-white w-2/3 rounded-md p-5 text-[12px] sm:text-[15px]">Caso já possua relacionamento com algum integrador ou instalador, solicite que o mesmo realize o cadastro na plataforma Appsolar, a fim de obter acesso à versão profissional que contém informações referentes a payback, TIR e fluxo de caixa.</p>
            @endif
            @if($site)
                <p class="absolute top-[80%] bg-black opacity-80 text-white w-2/3 rounded-md p-5 text-[12px] sm:text-[15px]">Agradecemos seu interesse em procurar a nossa empresa para economizar na sua conta de energia. Estamos com seu contato e em breve retornaremos com mais informações!</p>
            @endif
        </div>
    </div>
</div>
