<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-image: url('{{ asset('logo/dua.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        @media (max-width: 640px) {

            .text-center .text-4xl {
                font-size: 2.5rem;
            }

            .max-w-xs-custom {
                max-width: 20rem;
                width: 90%;
            }

            .backdrop-blur-none-sm {
                backdrop-filter: none;
            }
        }

    </style>
</head>
<body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col justify-center items-center relative py-4 sm:py-0">
        <div class="absolute inset-0 bg-black opacity-40"></div>

        <div class="relative z-10 w-full sm:max-w-md px-4 sm:px-6 py-4">
            <div class="text-center mb-6 sm:mb-8">
                <a href="/" wire:navigate>
                    <span class="text-3xl sm:text-4xl font-extrabold text-white drop-shadow-xl transition-all duration-300 hover:scale-105">P2TSP-24</span>
                </a>
            </div>

            <div class="bg-white bg-opacity-80 shadow-lg sm:shadow-xl rounded-lg overflow-hidden mx-auto backdrop-filter backdrop-blur-sm
                        sm:max-w-md max-w-xs-custom backdrop-blur-none-sm">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
