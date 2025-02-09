<div
    class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex flex-col items-center justify-center">

    <div class="text-center text-white p-6">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6">Bem-vindo ao Nosso Site</h1>
        <p class="text-xl mb-8">Conecte-se ou crie uma conta para começar sua jornada conosco!</p>

        <!-- Botões de Login e Registro -->
        <div class="flex justify-center gap-6">
            <!-- Botão de Login -->
            <a href="{{ route('login') }}"
               class="bg-white text-indigo-600 hover:bg-indigo-600 hover:text-white py-3 px-6 rounded-full text-lg font-semibold transition duration-300 ease-in-out">
                Login
            </a>
            <a x-on:click="$dispatch('open-side-modal', { componentName: '', params: {}, events:[] })" class="w-full md:w-20 text-center cursor-pointer block px-2 py-1 text-xs bg-blue-black text-white rounded hover:bg-opacity-50 font-bold">Abrir modal</a>
            <a x-on:click="$dispatch('open-side-modal2', { componentName: '', params: {}, events:[] })" class="w-full md:w-20 text-center cursor-pointer block px-2 py-1 text-xs bg-blue-black text-white rounded hover:bg-opacity-50 font-bold">Abrir modal2</a>
            <!-- Botão de Registro -->
            <a href="{{ route('register') }}"
               class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-indigo-600 py-3 px-6 rounded-full text-lg font-semibold transition duration-300 ease-in-out">
                Registre-se
            </a>
        </div>
    </div>

</div>
