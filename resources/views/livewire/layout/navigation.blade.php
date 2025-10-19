<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-400 via-indigo-600 to-white-800 border-b border-blue-100 sticky top-0 z-50 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="text-2xl font-bold text-red-600 shrink-0 flex items-center space-x-2">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="{{ asset('logo/logo.jpg') }}" alt="Logo P2TSP-24" class="h-10 w-auto">
                        <span>P2TSP-24</span>
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @hasanyrole('admin|direktur')
                    <x-nav-link :href="route('surat-masuk')" :active="request()->routeIs('surat-masuk')" wire:navigate>
                        {{ __('Surat Masuk') }}
                    </x-nav-link>
                    @endhasanyrole
                    @can('kelola surat')
                    <x-nav-link :href="route('surat-keluar')" :active="request()->routeIs('surat-keluar')" wire:navigate>
                        {{ __('Surat Keluar') }}
                    </x-nav-link>
                    @endcan
                    @hasrole('admin')
                    <x-nav-link :href="route('disposisi.riwayat')" :active="request()->routeIs('disposisi.riwayat')" wire:navigate>
                        {{ __('Riwayat Disposisi') }}
                    </x-nav-link>
                    @endrole
                    {{-- <x-nav-link :href="route('disposisi.masuk')" :active="request()->routeIs('disposisi.masuk')" wire:navigate>
                        {{ __('Disposisi Masuk') }}
                    </x-nav-link> --}}
                    @hasanyrole('admin|direktur')
                    <x-nav-link :href="route('laporan')" :active="request()->routeIs('laporan')" wire:navigate>
                        {{ __('Laporan') }}
                    </x-nav-link>
                    @endhasanyrole
                    {{-- Dropdown Admin (Kelola Pengguna & Log Aktivitas) --}}
                    @role('admin')
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5
    transition duration-150 ease-in-out h-full
    {{ request()->routeIs('pengguna') || request()->routeIs('log.aktivitas')
        ? 'border-indigo-500 text-white-900'
        : 'border-transparent text-white-500 hover:text-white-700 hover:border-white-300' }}">
                                    {{ __('Admin') }}
                                    <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('pengguna')" wire:navigate>
                                    {{ __('Kelola Pengguna') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('log.aktivitas')" wire:navigate>
                                    {{ __('Log Aktivitas') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('jabatan.index')" :active="request()->routeIs('jabatan.index')">
                                    {{ __('Jabatan') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('roles.index')" :active="request()->routeIs('roles.index')">
                                    {{ __('Roles') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endrole
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <livewire:notification-bell />
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <livewire:notification-bell />
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @hasanyrole('admin|direktur')
            <x-responsive-nav-link :href="route('surat-masuk')" :active="request()->routeIs('surat-masuk')" wire:navigate>
                {{ __('Surat Masuk') }}
            </x-responsive-nav-link>
            @endhasanyrole
            @can(abilities: 'kelola surat')
            <x-responsive-nav-link :href="route('surat-keluar')" :active="request()->routeIs('surat-keluar')">
                {{ __('Surat Keluar') }}
            </x-responsive-nav-link>
            @endcan
            {{-- <x-responsive-nav-link :href="route('disposisi.masuk')" :active="request()->routeIs('disposisi.masuk')" wire:navigate>
                {{ __('Disposisi Masuk') }}
            </x-responsive-nav-link> --}}
            @role('admin')
            <x-responsive-nav-link :href="route('disposisi.riwayat')" :active="request()->routeIs('disposisi.riwayat')" wire:navigate>
                {{ __('Riwayat Disposisi') }}
            </x-responsive-nav-link>
            @endrole
            @hasanyrole('admin|direktur')
            <x-responsive-nav-link :href="route('laporan')" :active="request()->routeIs('laporan')">
                {{ __('Laporan') }}
            </x-responsive-nav-link>
            @endhasanyrole
            @role('admin')
            <x-responsive-nav-link :href="route('pengguna')" :active="request()->routeIs('pengguna')" wire:navigate>
                {{ __('Kelola Pengguna') }}
            </x-responsive-nav-link>
            @endrole
            @role('admin')
            <x-responsive-nav-link :href="route('log.aktivitas')" :active="request()->routeIs('log.aktivitas')">
                {{ __('Log Aktivitas') }}
            </x-responsive-nav-link>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
