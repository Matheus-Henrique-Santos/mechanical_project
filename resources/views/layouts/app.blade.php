<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Inclua jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <!-- Em resources/views/layouts/app.blade.php, adicione no head -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.css"/>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        :root{
            --user-primary-color: hsl(<?php echo e(session()->get('whitelabelSetup')['whiteLabelBackgroundColor'] ?? ''); ?>);
            --text-primary-color: hsl(<?php echo e(session()->get('whitelabelSetup')['whiteLabelTextColor'] ?? ''); ?>);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-ND2J82J"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5BSMP3K"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@livewire('sideModal')
@livewire('sideModal2')

@livewire('component.modal-nivel1')
@livewire('component.modal-nivel2')
@livewire('component.modal-nivel3')
@livewire('component.modal-nivel4')
@livewire('component.modal-confirm')
@livewire('component.modal-center')

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
        <x-navbar-guest id="navbar"/>
        <main>
            {{ $slot }}
        </main>
    </div>
@endif

@livewireScripts
@stack('scripts')

<script>
    window.addEventListener('load', function () {
        const navbar = document.getElementById('navbar');
        const content = document.getElementById('content');
        const navbarHeight = navbar.offsetHeight;

        const screenHeight = window.innerHeight;
        const adjustedHeight = screenHeight - navbarHeight;

        content.style.height = `${adjustedHeight}px`;
    });

    function maskPhone(value) {
        return value.replace(/[^0-9]/g, '').length > 10 ? '(99) 99999-9999' : '(99) 9999-9999';
    }
</script>
</body>

<style>
    .spinner {
        -webkit-animation: rotator 1.4s linear infinite;
        animation: rotator 1.4s linear infinite;
    }

    @-webkit-keyframes rotator {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
        }
    }

    @keyframes rotator {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
        }
    }

    .path {
        stroke-dasharray: 187;
        stroke-dashoffset: 0;
        -webkit-transform-origin: center;
        -ms-transform-origin: center;
        transform-origin: center;
        -webkit-animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
        animation: dash 1.4s ease-in-out infinite, colors 5.6s ease-in-out infinite;
    }

    @-webkit-keyframes colors {
        0% {
            stroke: red;
        }
        14.285714286% {
            stroke: orange;
        }
        28.571428572% {
            stroke: yellow;
        }
        42.857142858% {
            stroke: green;
        }
        57.142857144% {
            stroke: blue;
        }
        71.42857143% {
            stroke: indigo;
        }
        100% {
            stroke: violet;
        }
    }

    @keyframes colors {
        0% {
            stroke: red;
        }
        14.285714286% {
            stroke: orange;
        }
        28.571428572% {
            stroke: yellow;
        }
        42.857142858% {
            stroke: green;
        }
        57.142857144% {
            stroke: blue;
        }
        71.42857143% {
            stroke: indigo;
        }
        100% {
            stroke: violet;
        }
    }

    @-webkit-keyframes dash {
        0% {
            stroke-dashoffset: 187;
        }
        50% {
            stroke-dashoffset: 46.75;
            -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
        }
        100% {
            stroke-dashoffset: 187;
            -webkit-transform: rotate(450deg);
            transform: rotate(450deg);
        }
    }

    @keyframes dash {
        0% {
            stroke-dashoffset: 187;
        }
        50% {
            stroke-dashoffset: 46.75;
            -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
        }
        100% {
            stroke-dashoffset: 187;
            -webkit-transform: rotate(450deg);
            transform: rotate(450deg);
        }
    }
</style>
</html>
