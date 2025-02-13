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
                        <p class="text-gray-700 text-[14px] font-medium">Nome Fantasia</p>
                        <input type="text" name="name" placeholder="Nome do responsável"
                               wire:model="formData.name"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.name')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Razão Social</p>
                        <input type="text" name="lastName" placeholder="Sobrenome do responsável"
                               wire:model="formData.lastName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.lastName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">CNPJ</p>
                        <input type="text" name="lastName" placeholder="Sobrenome do responsável"
                               wire:model="formData.lastName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.lastName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Telefone</p>
                        <input type="text" name="firstName" placeholder="Nome do responsável"
                               wire:model="formData.firstName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.firstName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">CEP</p>
                        <input type="text" name="lastName" placeholder="Sobrenome do responsável"
                               wire:model="formData.lastName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.lastName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Cidade</p>
                        <input type="text" disabled name="lastName" placeholder="Sobrenome do responsável"
                               wire:model="formData.lastName"
                               class="border border-gray-300 bg-gray-200 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.lastName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-[70px]">
                        <p class="text-gray-700 text-[14px] font-medium">UF</p>
                        <input type="text" disabled name="lastName" placeholder="UF" wire:model="formData.lastName"
                               class="border border-gray-300 bg-gray-200 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.lastName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Endereço</p>
                        <input type="text" name="firstName" placeholder="Nome do responsável"
                               wire:model="formData.firstName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.firstName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Bairro</p>
                        <input type="text" name="lastName" placeholder="Sobrenome do responsável"
                               wire:model="formData.lastName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.lastName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-[70px]">
                        <p class="text-gray-700 text-[14px] font-medium">Número</p>
                        <input type="text" name="lastName" placeholder="Número" wire:model="formData.lastName"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.lastName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Complemento</p>
                        <input type="text" name="lastName" placeholder="UF" wire:model="formData.lastName"
                               class="border border-gray-300  outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500"
                               minlength="3" maxlength="30">
                        @error('formData.lastName')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col justify-center">
                    <h1 class="text-lg font-bold text-black">
                        Dados do usúario final
                    </h1>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Nome</p>
                        <input type="text" name="name" placeholder="Digite o seu nome"
                               wire:model="formData.name"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500">
                        @error('formData.name')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">CPF</p>
                        <input type="email" name="email" placeholder="Digite o seu email"
                               wire:model="formData.cpf"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500">
                        @error('formData.email')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-row gap-4">
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">E-mail</p>
                        <input type="email" name="email" placeholder="Digite o seu email"
                               wire:model="formData.email"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500">
                        @error('formData.email')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Senha</p>
                        <input type="password" name="password" placeholder="Digite a sua senha"
                               wire:model="formData.password"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500">
                        @error('formData.password')
                        <span class="text-red-500 text-[12px]">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-black flex flex-col gap-0.5 w-full">
                        <p class="text-gray-700 text-[14px] font-medium">Confirmar Senha</p>
                        <input type="password" name="password" placeholder="Digite a sua senha"
                               wire:model="formData.password"
                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] invalid:border-red-500">
                        @error('formData.firstName')
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
