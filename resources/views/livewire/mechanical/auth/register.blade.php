{{--<div class="flex flex-col justify-center items-center mt-14">--}}
{{--    <div class="w-[1000px] p-4 shadow-lg rounded">--}}

{{--        <div class="flex flex-col justify-center mt-3 mb-3">--}}
{{--            <h1 class="text-2xl font-bold text-black">--}}
{{--                Dados do integrador--}}
{{--            </h1>--}}
{{--        </div>--}}

{{--        <form method="POST" wire:submit.prevent="save" class="flex flex-col gap-2">--}}
{{--            @csrf--}}
{{--            <div class="flex flex-col gap-3 w-full">--}}
{{--                <div class="flex flex-row gap-4">--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">Razão Social</p>--}}
{{--                        <input type="text" name="socialName" placeholder="Razão Social"--}}
{{--                               wire:model="formData.socialName"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] "--}}
{{--                               minlength="3" maxlength="30">--}}
{{--                        @error('formData.socialName')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">Nome Fantasia</p>--}}
{{--                        <input type="text" placeholder="Nome Fantasia"--}}
{{--                               wire:model="formData.fantasyName"--}}
{{--                               id="formData.fantasyName"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] "--}}
{{--                               minlength="3" maxlength="30">--}}
{{--                        @error('formData.fantasyName')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">CNPJ</p>--}}
{{--                        <input type="text" name="cnpj" placeholder="CNPJ"--}}
{{--                               wire:model="formData.cnpj"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff]"--}}
{{--                               x-mask="99.999.999/9999-99">--}}
{{--                        @error('formData.cnpj')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="flex flex-row gap-4">--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">Telefone ou Celular</p>--}}
{{--                        <input type="text" name="cellphone" placeholder="Telefone ou Celular"--}}
{{--                               wire:model="formData.cellphone"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff]"--}}
{{--                               maxlength="15" x-mask:dynamic="maskPhone"--}}
{{--                        >--}}
{{--                        @error('formData.cellphone')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">CEP</p>--}}
{{--                        <input type="text" name="zipCode" placeholder="Digite seu CEP"--}}
{{--                               wire:model.blur="zipCode"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] "--}}
{{--                               maxlength="9" x-mask="99999-999">--}}
{{--                        @error('zipCode')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">Cidade</p>--}}
{{--                        <input type="text" name="city" placeholder="Cidade" wire:model="formData.city"--}}
{{--                               class="border border-gray-300 bg-gray-200 outline-none p-2 pl-3 rounded focus:border-[#0084ff]">--}}
{{--                        @error('formData.city')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}

{{--                    <div class="text-black flex flex-col gap-0.5 w-[70px]">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">UF</p>--}}
{{--                        <input type="text" disabled name="uf" placeholder="UF" wire:model="formData.uf"--}}
{{--                               class="border border-gray-300 bg-gray-200 outline-none p-2 pl-3 rounded focus:border-[#0084ff] "--}}
{{--                               minlength="3" maxlength="30">--}}
{{--                        @error('formData.uf')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}

        <div class="flex flex-col justify-center mt-3 mb-3">
            <h1 class="text-2xl font-bold text-black">
                Dados do integrador
            </h1>
        </div>

{{--                <div class="flex flex-row gap-4">--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">Nome</p>--}}
{{--                        <input type="text" name="name" placeholder="Digite o seu nome"--}}
{{--                               wire:model="formData.name"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">--}}
{{--                        @error('formData.name')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">CPF</p>--}}
{{--                        <input type="text" name="cpf" placeholder="Digite o seu CPF"--}}
{{--                               wire:model="formData.cpf"--}}
{{--                               x-mask="999.999.999-99"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">--}}
{{--                        @error('formData.cpf')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="flex flex-row gap-4">--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">E-mail</p>--}}
{{--                        <input type="email" name="email" placeholder="Digite o seu email"--}}
{{--                               wire:model="formData.email"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">--}}
{{--                        @error('formData.email')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">Senha</p>--}}
{{--                        <input type="password" name="password" placeholder="Digite a sua senha"--}}
{{--                               wire:model="formData.password"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">--}}
{{--                        @error('formData.password')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                    <div class="text-black flex flex-col gap-0.5 w-full">--}}
{{--                        <p class="text-gray-700 text-[14px] font-medium">Confirmar Senha</p>--}}
{{--                        <input type="password" name="password_confirmed" placeholder="Confirme sua senha"--}}
{{--                               wire:model="formData.password_confirmed"--}}
{{--                               class="border border-gray-300 outline-none p-2 pl-3 rounded focus:border-[#0084ff] ">--}}
{{--                        @error('formData.password_confirmed')--}}
{{--                        <span class="text-red-500 text-[12px]">{{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <button type="submit"--}}
{{--                        class="bg-[#043873] w-full font-bold text-white rounded-[5px] py-2 transition-all duration-200 active:scale-[0.99] flex flex-row justify-center">--}}
{{--                    <span>Enviar dados para Análise</span>--}}
{{--                </button>--}}
{{--            </div>--}}

{{--        </form>--}}

{{--        <div class="flex flex-col gap-3 mt-4">--}}
{{--            <div class="flex flex-row justify-center text-[15px]">--}}
{{--                <p class="text-gray-700 font-medium ">--}}
{{--                    Já possuí uma conta? <span class="text-[#0084ff] font-medium cursor-pointer hover:underline"--}}
{{--                                               onclick="window.location = '{{ route('login') }}'">Fazer Login</span>--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <div class="mt-1">--}}
{{--                <p class="text-gray-700 font-medium text-[13.5px] text-center">--}}
{{--                    Ao continuar, você concorda com os <span--}}
{{--                        class="text-[#0084ff] hover:underline cursor-pointer">Termos</span> e <span--}}
{{--                        class="text-[#0084ff] hover:underline cursor-pointer">Política de--}}
{{--                    Privacidade</span>.--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<div>
    <div wire:loading wire:target="submit"
         class="bg-gray-500/50 absolute min-h-screen w-full top-0 left-0 z-60">
        <div class="relative flex items-center justify-center h-screen">
            <div class="relative flex items-center justify-center text-white animate-pulse">
                <span class="border-r-8 border-primary h-40 w-40 rounded-full animate-spin"></span>
                <div class="absolute animate-pulse text-center">
                    Concluíndo<br>cadastro...
                </div>
            </div>
        </div>
    </div>
    <form
        wire:submit.prevent="submit"
        method="post"
        class="rounded-2xl p-5 lg:p-10 bg-white dark:bg-gray-600 w-full grid grid-cols-1 gap-y-1 h-auto lg:h-[62    4px] w-full lg:w-[510px] justify-between"
    >
        <div class="flex justify-center text-center h-20">
            <figure class="w-full h-10 flex items-center justify-center">
                <img class="object-contain max-w-full max-h-full" id="logo" src="https://time.appsolar.com.br/file/af2254c7-ae8e-466e-8b9a-654aae03f58b" alt="">
            </figure>
        </div>

        @csrf

        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-12">
                <x-input
                    wire:model.defer="state.name"
                    placeholder="Digite seu nome"
                    label="Nome completo do responsável"
                    error="name"
                />
            </div>

            <div class="col-span-12">
                <x-input
                    type="email"
                    wire:model.defer="state.email"
                    label="E-mail"
                    error="email"
                />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-input
                    input-mask="cell"
                    wire:model.defer="state.cell"
                    placeholder="Digite seu número"
                    label="Celular (WhatsApp)"
                    error="cell"
                />
            </div>

            <div class="col-span-12 md:col-span-6">
                <x-input
                    input-mask="cnpj"
                    wire:model.defer="state.cnpj"
                    label="CNPJ"
                    error="cnpj"
                />
            </div>

            <div class="col-span-12">
                <div class="mt-1 relative rounded-md">
                    <x-input
                        wire:model.defer="state.subdomain"
                        pattern="[a-zA-Z0-9]+"
                        title="Não use caracteres especiais e nem espaço"
                        label="Nome da plataforma"
                        error="''"
                    />
                    <div class="absolute inset-y-0 right-0 px-3 flex items-center pointer-events-none text-gray-600 text-xs md:text-base">.appsolar.com.br</div>
                </div>
                @error('subdomain')
                <small class="text-red-500">
                    {{$message}}
                </small>
                @enderror
            </div>

            <div class="col-span-12 w-full font-normal">
                <label class="ed-form-label-checkbox w-full">
                    <p class="break-words">
                        A Edmond está comprometida em proteger e respeitar a sua privacidade e só utilizaremos as suas informações pessoais para administrar a sua conta e para fornecer os produtos e serviços que solicitar.
                        <br>
                    </p>
                </label>
            </div>

            <div class="col-span-12 font-normal">
                <label class="ed-form-label-checkbox w-full">
                    <input
                        type="checkbox"
                        id="checkbox-policy"
                        wire:model.defer="state.policy_private"
                        @class([
                            'ed-form-checkbox',
                            'border-red-600' => $errors->has('policy_private')
                        ])
                    />
                    <span class="break-words w-72 lg:w-full">
                        Ao clicar, consente em permitir que a Edmond armazene e processe as informações pessoais submetidas acima
                        para lhe fornecermos os conteúdos pedidos de acordo com nosso
                        <a href="https://edmond.com.br/politica-aviso-de-privacidade-e-cookies-appsolar/" target="_blank" class="text-primary">Aviso de Privacidade</a>
                        e
                        <a href="https://edmond.com.br/politica-termos-de-uso-appsolar/" target="_blank" class="text-primary">Termos de Uso</a>.
                    </span>
                </label>
                @error('policy_private')
                <small class="text-red-500">{{$message}}</small>
                @enderror
            </div>
            <div class="col-span-12 font-normal">
                <label class="ed-form-label-checkbox w-full">
                    <input
                        type="checkbox"
                        id="checkbox-policy"
                        wire:model.defer="state.policy_sale"
                        @class([
                            'ed-form-checkbox',
                            'border-red-600' => $errors->has('policy_sale')
                        ])
                    />
                    <span class="break-words w-72 lg:w-full">
                        Acesse as Condições Gerais de Venda e Compra na AppSolar, <a target="_blank" class="text-primary" href="https://edmond.com.br/condicoes-gerais-venda-e-compra-appsolar/">clique aqui</a>.
                    </span>
                </label>
                @error('policy_sale')
                <small class="text-red-500">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="w-full flex items-center justify-center gap-x-5 py-2 mt-2 ">
            <button type="submit" class="border-2 border-transparent px-8 py-4 font-semibold text-sm rounded-bl-full rounded-r-full bg-primary hover:scale-105 hover:shadow-lg hover:shadow-gray-500/40 ease-in-out active:shadow-md active:brightness-110 w-max text-primary_text flex justify-center items-center">
                Cadastrar
            </button>
        </div>

        <div class="w-full flex items-center flex-col justify-center mt-4">
            <a href="{{route('login')}}" class="text-primary">Já tenho uma conta</a>
            <p class="text-gray-500"><a href="https://edmond.com.br/appsolar/" class="text-primary" target="_blank">Saiba mais</a></p>
        </div>
    </form>
</div>

