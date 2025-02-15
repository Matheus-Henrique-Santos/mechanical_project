<div class="flex flex-col justify-center items-center mt-14">
    <div class="w-[1000px] p-4 shadow-lg rounded">

        <div class="flex flex-col justify-center mt-3 mb-3">
            <h1 class="text-2xl font-bold text-black">
                Dados do integrador
            </h1>
        </div>

        <form method="POST" wire:submit.prevent="save" class="flex flex-col gap-2">
            @csrf
            <div class="flex flex-col gap-3 w-full">
                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Razão Social</p>
                        <input type="text" name="socialName" placeholder="Razão Social"
                               wire:model="formData.socialName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] "
                               minlength="3" maxlength="30">
                        @error('formData.socialName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Nome Fantasia</p>
                        <input type="text" placeholder="Nome Fantasia"
                               wire:model="formData.fantasyName"
                               id="formData.fantasyName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] "
                               minlength="3" maxlength="30">
                        @error('formData.fantasyName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">CNPJ</p>
                        <input type="text" name="cnpj" placeholder="CNPJ"
                               wire:model="formData.cnpj"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff]"
                               x-mask="99.999.999/9999-99">
                        @error('formData.cnpj')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Telefone ou Celular</p>
                        <input type="text" name="cellphone" placeholder="Telefone ou Celular"
                               wire:model="formData.cellphone"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff]"
                               maxlength="15" x-mask:dynamic="maskPhone"
                        >
                        @error('formData.cellphone')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">CEP</p>
                        <input type="text" name="zipCode" placeholder="Digite seu CEP"
                               wire:model.blur="zipCode"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] "
                               maxlength="9" x-mask="99999-999">
                        @error('zipCode')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Cidade</p>
                        <input type="text" name="city" placeholder="Cidade" wire:model="formData.city"
                               class="border border-gray-300 bg-gray-200 outline-none p-2 pl-3 rounded focus:border-[#0084ff]">
                        @error('formData.city')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-black flex flex-col gap-0.5 w-[70px]">
                        <p class="text-gray-700 text-[14px] font-medium">UF</p>
                        <input type="text" disabled name="uf" placeholder="UF" wire:model="formData.uf"
                               class="border border-gray-300 bg-gray-200 outline-none p-2 pl-3 rounded focus:border-[#0084ff] "
                               minlength="3" maxlength="30">
                        @error('formData.uf')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Endereço</p>
                        <input type="text" name="address" placeholder="Endereço"
                               wire:model="formData.address"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff]">
                        @error('formData.address')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Bairro</p>
                        <input type="text" name="neighborhood" placeholder="Bairro"
                               wire:model="formData.neighborhood"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff]" maxlength="40">
                        @error('formData.neighborhood')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-[100px]">
                        <p class="text-gray-700 text-[14px] font-medium">Número</p>
                        <input type="number" name="number" placeholder="Número" wire:model="formData.number"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff]" min="0">
                        @error('formData.number')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Complemento</p>
                        <input type="text" name="complement" placeholder="Complemento" wire:model="formData.complement"
                               class="border border-gray-300  outline-none p-2 pl-3 rounded focus:border-[#0084ff]" maxlength="50">
                        @error('formData.complement')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Nome</p>
                        <input type="text" name="name" placeholder="Digite o seu nome"
                               wire:model="formData.name"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">
                        @error('formData.name')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">CPF</p>
                        <input type="text" name="cpf" placeholder="Digite o seu CPF"
                               wire:model="formData.cpf"
                               x-mask="999.999.999-99"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">
                        @error('formData.cpf')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">E-mail</p>
                        <input type="email" name="email" placeholder="Digite o seu email"
                               wire:model="formData.email"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">
                        @error('formData.email')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Senha</p>
                        <input type="password" name="password" placeholder="Digite a sua senha"
                               wire:model="formData.password"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">
                        @error('formData.password')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Confirmar Senha</p>
                        <input type="password" name="password_confirmed" placeholder="Confirme sua senha"
                               wire:model="formData.password_confirmed"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">
                        @error('formData.password_confirmed')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit"
                        class="bg-[#043873] w-full font-bold text-white rounded-[5px] py-2 transition-all duration-200 active:scale-[0.99] flex flex-row justify-center">
                    <span>Enviar dados para Análise</span>
                </button>
            </div>

        </form>

        <div class="flex flex-col gap-3 mt-4">
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
