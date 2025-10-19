<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
};
?>

<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-700 via-blue-600 to-indigo-800 border-b border-indigo-500 sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center space-x-3">
                <a href="/" class="flex items-center space-x-2">

                    <img src="{{ asset('logo/logos.png') }}" alt="Logo P2TSP-24" class="h-12 w-12 rounded-full bg-white p-1 border-2 border-blue-400 glow" />
                    <span class="text-2xl font-bold text-red-500 tracking-wide drop-shadow-[0_1px_2px_rgba(0,0,0,0.25)]">
                        P2TSP-24
                    </span>

                </a>
            </div>

            {{-- Main Nav --}}
            <div class="hidden sm:flex space-x-8 items-center">
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

                @hasanyrole('admin|direktur')
                <x-nav-link :href="route('laporan')" :active="request()->routeIs('laporan')" wire:navigate>
                    {{ __('Laporan') }}
                </x-nav-link>
                @endhasanyrole

                {{-- Admin Dropdown --}}
                @role('admin')
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-2 pt-1 border-b-2 text-sm font-medium leading-5
                                transition duration-150 ease-in-out h-full
                                {{ request()->routeIs('pengguna') || request()->routeIs('log.aktivitas')
                                    ? 'border-white text-white font-semibold'
                                    : 'border-transparent text-white/70 hover:text-white hover:border-white/50' }}">
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

            {{-- Right: Notification & Profile --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <livewire:notification-bell />

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white/90 hover:text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
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

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger (Mobile) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <livewire:notification-bell />
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Menu --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-700/95 backdrop-blur-md">
        <div class="pt-2 pb-3 space-y-1 text-white">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @hasanyrole('admin|direktur')
            <x-responsive-nav-link :href="route('surat-masuk')" :active="request()->routeIs('surat-masuk')" wire:navigate>
                {{ __('Surat Masuk') }}
            </x-responsive-nav-link>
            @endhasanyrole

            @can('kelola surat')
            <x-responsive-nav-link :href="route('surat-keluar')" :active="request()->routeIs('surat-keluar')" wire:navigate>
                {{ __('Surat Keluar') }}
            </x-responsive-nav-link>
            @endcan

            @role('admin')
            <x-responsive-nav-link :href="route('disposisi.riwayat')" :active="request()->routeIs('disposisi.riwayat')" wire:navigate>
                {{ __('Riwayat Disposisi') }}
            </x-responsive-nav-link>
            @endrole

            @hasanyrole('admin|direktur')
            <x-responsive-nav-link :href="route('laporan')" :active="request()->routeIs('laporan')" wire:navigate>
                {{ __('Laporan') }}
            </x-responsive-nav-link>
            @endhasanyrole

            @role('admin')
            <x-responsive-nav-link :href="route('pengguna')" :active="request()->routeIs('pengguna')" wire:navigate>
                {{ __('Kelola Pengguna') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('log.aktivitas')" :active="request()->routeIs('log.aktivitas')" wire:navigate>
                {{ __('Log Aktivitas') }}
            </x-responsive-nav-link>
            @endrole
        </div>

        <div class="pt-4 pb-1 border-t border-indigo-500">
            <div class="px-4 text-white">
                <div class="font-medium text-base" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-indigo-200">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 text-white">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
