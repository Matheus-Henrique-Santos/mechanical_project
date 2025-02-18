<div class="flex flex-col justify-center items-center mt-14">
    <div class="w-[700px] p-4 py-6 shadow-lg rounded-2xl border border-black">
        <div class="flex justify-center text-center h-20">
            <figure class="w-full h-10 flex items-center justify-center">
{{--                <img class="object-contain max-w-full max-h-full" id="logo" src="" alt="">--}}
                LOGO
            </figure>
        </div>

        <div class="flex flex-col justify-center mt-3 mb-3">
            <h1 class="text-xl font-bold text-black">
                Dados do integrador
            </h1>
        </div>

        <form method="POST" wire:submit.prevent="save" class="flex flex-col gap-4">
            @csrf
            <div class="flex flex-col gap-5 w-full">
                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <x-input wire:model="name" error="name" label="Nome completo do responsavel"/>
                    </div>
                </div>
                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <div class="mt-1 relative rounded-md">
                            <x-input wire:model.defer="subdomain" error="subdomain" label="Nome da plataforma"/>
                            <div
                                class="absolute inset-y-0 right-0 px-3 flex items-center pointer-events-none text-gray-600 text-xs md:text-base">
                                .mecanica.com.br
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <x-input type="email" wire:model="email" error="email" label="E-mail"/>
                    </div>
                </div>
                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <x-input x-mask:dynamic="maskPhone" wire:model="cellphone" error="cellphone"
                                 label="Celular (WhatsApp)"/>
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <x-input x-mask="99.999.999/9999-99" wire:model="cnpj" error="cnpj" label="CNPJ"/>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="bg-[#043873] w-full font-bold text-white rounded-[5px] py-2 transition-all duration-200 active:scale-[0.99] flex flex-row justify-center">
                        <span>Enviar dados para Análise</span>
                    </button>
                    <div wire:loading wire:target="save" class="absolute top-0 left-0 w-full h-full z-10">
                        <div class="w-full h-full rounded-md flex items-center justify-center bg-white/70">
                            <x-heroicon-s-arrow-path class="text-[#20392f] w-5 h-5 animate-spin"/>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <div class="flex flex-col gap-3 mt-8">
            <div class="flex flex-row justify-center text-[15px]">
                <p class="text-gray-700 font-medium ">
                    Já possuí uma conta? <span class="text-[#0084ff] font-medium cursor-pointer hover:underline"
                                               onclick="window.location = '{{ route('login') }}'">Fazer Login</span>
                </p>
            </div>
            <div class="mt-1">
                <p class="text-gray-700 font-medium text-[13.5px] text-center">
                    Ao continuar, você concorda com os <span
                        class="text-[#0084ff] hover:underline cursor-pointer">Termos</span> e <span
                        class="text-[#0084ff] hover:underline cursor-pointer">Política de
                    Privacidade</span>.
                </p>
            </div>
        </div>
    </div>
</div>
