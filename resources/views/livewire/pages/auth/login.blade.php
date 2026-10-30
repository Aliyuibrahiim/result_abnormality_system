<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $user = auth()->user();

        // Redirect based on role to avoid sending students/lecturers to admin URLs
        if ($user->hasRole('lecturer')) {
            $this->redirect(route('lecturer.result-upload', absolute: false), navigate: true);
        } elseif ($user->hasRole('student')) {
            $this->redirect(route('student.results', absolute: false), navigate: true);
        } else {
            // Admin and Exam Officers go to Dashboard (or their intended admin URL)
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<div>
    <div class="mb-6">
        <h2 class="text-[1.75rem] font-bold text-gray-900 mb-1" style="font-family: 'Outfit', sans-serif;">Welcome Back
        </h2>
        <p class="text-gray-500 text-[0.875rem]">Please sign in to your student or admin account.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Email Address / Matric
                No.</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-[18px] w-[18px] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                </div>
                <x-text-input wire:model="form.email" id="email"
                    class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5"
                    type="email" name="email" required autofocus autocomplete="username"
                    placeholder="e.g. U20XX1001@abu.edu.ng" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-[0.875rem] font-semibold text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[0.875rem] font-medium text-[#2563EB] hover:text-[#1D4ED8] text-decoration-none"
                        href="{{ route('password.request') }}" wire:navigate>
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-[18px] w-[18px] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                </div>
                <x-text-input wire:model="form.password" id="password"
                    class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input wire:model="form.remember" id="remember" type="checkbox"
                class="h-4 w-4 rounded border-gray-300 text-[#2563EB] focus:ring-[#2563EB]" name="remember">
            <label for="remember"
                class="ml-2 block text-[0.875rem] text-gray-500">{{ __('Remember this device') }}</label>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-white font-semibold shadow-[0_4px_12px_rgba(37,99,235,0.25)] transition-all hover:-translate-y-[1px] hover:shadow-[0_6px_16px_rgba(37,99,235,0.35)]"
                style="background: linear-gradient(135deg, #2563EB, #1D4ED8);">
                <span wire:loading.remove wire:target="login">Sign In to Portal</span>
                <span wire:loading wire:target="login">Signing in...</span>
                <svg class="w-[18px] h-[18px]" wire:loading.remove wire:target="login"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14" />
                    <path d="m12 5 7 7-7 7" />
                </svg>
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="mt-6 pt-4 border-t border-gray-200 text-center text-[0.875rem] text-gray-500">
            New student?
            <a href="{{ route('register') }}" class="font-bold text-[#2563EB] text-decoration-none ml-1"
                wire:navigate>Create an account</a>
        </div>
    @endif
</div>
