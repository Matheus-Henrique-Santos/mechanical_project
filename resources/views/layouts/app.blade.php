<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Em resources/views/layouts/app.blade.php, adicione no head -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
    @livewire('sideModal')
    @livewire('sideModal2')
{{--        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">--}}
{{--            @include('layouts.navigation')--}}

            <!-- Page Heading -->
{{--            @isset($header)--}}
{{--                <header class="bg-white dark:bg-gray-800 shadow">--}}
{{--                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                        {{ $header }}--}}
{{--                    </div>--}}
{{--                </header>--}}
{{--            @endisset--}}

            @if(Auth::check() && !request()->is('/'))
                <div class="w-full h-full flex flex-row border ">
                    <x-navbar-auth>
                        <main>
                            {{ $slot }}
                        </main>
                    </x-navbar-auth>
                </div>
            @else
                <div>
                    <x-navbar-guest />
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            @endif

{{--        </div>--}}
        @livewireScripts
        @stack('scripts')
    </body>
</html>
