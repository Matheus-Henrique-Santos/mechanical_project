<nav
    class="w-full border-b border-b-blue-link bg-blue-600 text-white flex flex-row justify-between px-10 items-center p-4"
    id="navbar">
    <div>

        <h2><a href="{{ route('home') }}">Logo</a></h2>
    </div>
    <div class="flex flex-row list-none gap-4">
        <ul class="flex gap-7">
            <li><a href="" class="hover:underline font-medium">Soluções</a></li>
            <li><a href="" class="hover:underline font-medium">Recursos</a></li>
            <li><a href="" class="hover:underline font-medium">Planos</a></li>
        </ul>
    </div>
    {{--    @if(auth()->check())--}}
    {{--        <div class="flex flex-row gap-2">--}}
    {{--            @if(auth()->user()->role === 'customer')--}}
    {{--                @if(auth()->user()->business || auth()->user()->role === 'admin')--}}
    {{--                    <h1><a href="{{ route('dashboard') }}">Dashboard</a></h1>--}}
    {{--                @else--}}
    {{--                    <h1><a href="{{ route('complete-profile') }}">Complete seu Cadastro</a></h1>--}}
    {{--                @endif--}}
    {{--                <a href="{{ route('logout') }}">Sair</a>--}}
    {{--            @endif--}}
    {{--        </div>--}}
    {{--    @else--}}
    {{--        <div class="flex flex-row gap-4 items-center">--}}
    {{--            <a href="{{ route('login') }}" class="hover:underline font-medium">Login</a>--}}
    {{--            <button class="py-[5px] px-[17px] bg-blue-white rounded-[6px] font-medium active:scale-[0.97]" onclick="window.location='{{ route('register') }}'">--}}
    {{--                Comece já--}}
    {{--            </button>--}}
    {{--        </div>--}}
    {{--    @endif--}}
</nav>

