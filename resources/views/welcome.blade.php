<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-t">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Surat - Manajemen Surat Digital</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <div class="min-h-screen flex flex-col">
        <header class="w-full shadow-sm bg-white/80 backdrop-blur-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex justify-between items-center h-16">
                    <div class="text-2xl font-bold text-blue-600">
                        <a href="/">E-Surat</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-2 inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition">
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </nav>
            </div>
        </header>

        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-12 items-center py-20 sm:py-32">
                    <div class="text-center md:text-left">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight">
                            Manajemen Surat Modern,
                            <span class="block text-blue-600 mt-2">Efisien, dan Terintegrasi.</span>
                        </h1>
                        <p class="mt-6 text-lg text-gray-600">
                            Ubah cara Anda mengelola korespondensi. Lacak, arsipkan, dan distribusikan surat masuk & keluar dengan mudah dalam satu platform digital yang aman.
                        </p>
                        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                            <a href="{{ route('register') }}" class="w-full sm:w-auto inline-block text-center text-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 px-8 py-3 rounded-lg shadow-md transition">
                                Mulai Sekarang
                            </a>
                            <a href="#fitur" class="w-full sm:w-auto inline-block text-center text-lg font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 px-8 py-3 rounded-lg transition">
                                Pelajari Fitur
                            </a>
                        </div>
                    </div>
                    <div class="hidden md:block">

                    </div>
                </div>
            </div>
        </main>

        <section id="fitur" class="bg-white py-20 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Semua yang Anda Butuhkan</h2>
                    <p class="mt-4 text-lg text-gray-600">Fitur lengkap untuk digitalisasi sistem persuratan Anda.</p>
                </div>
                <div class="mt-16 grid md:grid-cols-3 gap-10">
                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Alur Kerja Disposisi</h3>
                        <p class="mt-2 text-base text-gray-600">Delegasikan surat kepada staf dengan instruksi yang jelas dan lacak statusnya.</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Arsip Digital Terpusat</h3>
                        <p class="mt-2 text-base text-gray-600">Kelola surat masuk dan keluar dalam satu repositori yang aman dan mudah dicari.</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <h3 class="mt-5 text-lg font-semibold text-gray-900">Notifikasi Real-time</h3>
                        <p class="mt-2 text-base text-gray-600">Dapatkan pemberitahuan instan di aplikasi dan email untuk setiap tugas baru.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="w-full bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <p class="text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} E-Surat. All rights reserved. Dibangun dengan penuh semangat 🚀.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
