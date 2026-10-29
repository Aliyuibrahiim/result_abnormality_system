<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-6">
        <h2 class="text-[1.75rem] font-bold text-gray-900 mb-1" style="font-family: 'Outfit', sans-serif;">Forgot Password</h2>
        <p class="text-gray-500 text-[0.875rem]">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-4">
        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[0.875rem] font-semibold text-gray-700 mb-1">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-[18px] w-[18px] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <x-text-input wire:model="email" id="email" class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5" type="email" name="email" required autofocus placeholder="e.g. U20XX1001@abu.edu.ng" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-white font-semibold shadow-[0_4px_12px_rgba(37,99,235,0.25)] transition-all hover:-translate-y-[1px] hover:shadow-[0_6px_16px_rgba(37,99,235,0.35)]" style="background: linear-gradient(135deg, #2563EB, #1D4ED8);">
                <span wire:loading.remove wire:target="sendPasswordResetLink">Email Password Reset Link</span>
                <span wire:loading wire:target="sendPasswordResetLink">Sending...</span>
                <svg class="w-[18px] h-[18px]" wire:loading.remove wire:target="sendPasswordResetLink" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
        </div>
    </form>
    
    <div class="mt-6 pt-4 border-t border-gray-200 text-center text-[0.875rem] text-gray-500">
        Remember your password?
        <a href="{{ route('login') }}" class="font-bold text-[#2563EB] text-decoration-none ml-1" wire:navigate>Back to Login</a>
    </div>
</div>
