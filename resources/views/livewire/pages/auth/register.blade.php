<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-6">
        <h2 class="text-[1.75rem] font-bold text-gray-900 mb-1" style="font-family: 'Outfit', sans-serif;">Create Account</h2>
        <p class="text-gray-500 text-[0.875rem]">Sign up to access the KASU Result Tracking System.</p>
    </div>

    <form wire:submit="register" class="space-y-4">
        <!-- Name -->
        <div>
            <label for="name" class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Full Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-[18px] w-[18px] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <x-text-input wire:model="name" id="name" class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5" type="text" name="name" required autofocus autocomplete="name" placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Email Address / Matric No.</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-[18px] w-[18px] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <x-text-input wire:model="email" id="email" class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5" type="email" name="email" required autocomplete="username" placeholder="e.g. U20XX1001@kasu.edu.ng" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-[18px] w-[18px] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <x-text-input wire:model="password" id="password" class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5"
                                type="password"
                                name="password"
                                required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Confirm Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-[18px] w-[18px] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-white font-semibold shadow-[0_4px_12px_rgba(37,99,235,0.25)] transition-all hover:-translate-y-[1px] hover:shadow-[0_6px_16px_rgba(37,99,235,0.35)]" style="background: linear-gradient(135deg, #2563EB, #1D4ED8);">
                <span wire:loading.remove wire:target="register">Create Account</span>
                <span wire:loading wire:target="register">Creating account...</span>
                <svg class="w-[18px] h-[18px]" wire:loading.remove wire:target="register" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
        </div>
    </form>
    
    <div class="mt-6 pt-4 border-t border-gray-200 text-center text-[0.875rem] text-gray-500">
        Already registered?
        <a href="{{ route('login') }}" class="font-bold text-[#2563EB] text-decoration-none ml-1" wire:navigate>Sign In</a>
    </div>
</div>
