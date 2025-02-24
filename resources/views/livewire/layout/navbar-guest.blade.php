<nav
    class="w-full border-b border-b-blue-link bg-blue-600 text-white flex flex-row justify-between px-10 items-center p-4"
    id="navbar">
    <div>

        <h2><a href="{{ route('home') }}">Logo</a></h2>
    </div>
    <div class="flex flex-row list-none gap-4">
        <ul class="flex gap-2">
            <li><a href="{{ route('login') }}" class="hover:underline font-medium">Login</a></li>
            <li><a href="{{ route('register') }}" class="hover:underline font-medium">Register</a></li>
        </ul>
    </div>
</nav>

