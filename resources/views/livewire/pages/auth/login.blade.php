<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>
<div class="p-6 sm:p-8">
    <div>
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form wire:submit="login">
            <div>
                {{-- Warna teks label diubah menjadi lebih gelap --}}
                <x-input-label for="email" :value="__('Email')" class="text-gray-800" />
                {{-- Latar belakang input putih solid, border saat fokus biru --}}
                <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full bg-white border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" type="email" name="email" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-800" />
                <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full bg-white border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember" class="inline-flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-700">{{ __('Ingat Saya') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-6">
                {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-700 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Lupa kata sandi?') }}
                </a>
                @endif --}}

                <x-primary-button class="ms-3 bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 text-white font-bold py-2 px-4 rounded transition-all duration-300">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
