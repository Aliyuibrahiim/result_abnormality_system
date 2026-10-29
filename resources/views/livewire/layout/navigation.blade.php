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

<!-- Sidebar Navigation Wrapper (Single Root Element for Livewire) -->
<div>
<aside 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 w-64 text-white transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col justify-between h-full min-h-screen"
    style="background: linear-gradient(135deg, #1E3A8A 0%, #2563EB 40%, #0F172A 100%);">
    
    <!-- Background Decorator -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -right-[20%] w-[150%] h-[50%] rounded-full z-0" style="background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);"></div>
    </div>

    <!-- Sidebar Header (Logo) -->
    <div class="relative z-10 flex items-center justify-between px-6 py-5 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-decoration-none" wire:navigate>
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-[#2563EB]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a2 2 0 0 1-.019 3.138l-4.04 3.737-1.127.911a2 2 0 0 1-2.474 0l-1.127-.911-4.04-3.737a2 2 0 0 1-.019-3.138l8.28-7.08a2 2 0 0 1 2.583 0z"/><path d="M12 18.5V22"/><path d="M8.5 15.5v3.66a2 2 0 0 0 1 1.73l2 1.15a2 2 0 0 0 2 0l2-1.15a2 2 0 0 0 1-1.73V15.5"/><path d="m3 11 9-8 9 8-9 8-9-8Z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white mb-0 brand-font tracking-tight">KASU</h2>
                <p class="text-white/75 text-[0.65rem] uppercase font-bold tracking-wider mb-0">Result System</p>
            </div>
        </a>
        
        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden text-white/70 hover:text-white p-1 rounded-md bg-white/10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Navigation Links -->
    <nav class="relative z-10 flex-1 px-4 py-6 overflow-y-auto space-y-2">
        <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-3 mt-2">Main Menu</p>
        
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
            <span class="text-[0.95rem]">Dashboard</span>
        </a>

        @role('admin')
            <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-3 mt-6">Administration</p>
            
            <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
                <svg class="w-5 h-5 {{ request()->routeIs('admin.users') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="text-[0.95rem]">Manage Users</span>
            </a>
            
            <a href="{{ route('admin.courses') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.courses') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
                <svg class="w-5 h-5 {{ request()->routeIs('admin.courses') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                <span class="text-[0.95rem]">Courses</span>
            </a>

            <a href="{{ route('admin.academic-sessions') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.academic-sessions') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
                <svg class="w-5 h-5 {{ request()->routeIs('admin.academic-sessions') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M10 16h4"/></svg>
                <span class="text-[0.95rem]">Academic Sessions</span>
            </a>
        @endrole

        @role('admin|exam_officer')
            <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-3 mt-6">Monitoring</p>
            
            <a href="{{ route('admin.results') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.results*') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.results*') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                    <span class="text-[0.95rem]">All Results</span>
                </div>
            </a>

            <a href="{{ route('admin.abnormalities') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.abnormalities*') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.abnormalities*') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                    <span class="text-[0.95rem]">Flagged Results</span>
                </div>
            </a>
        @endrole

        @role('student')
            <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-3 mt-6">Academics</p>
            
            <a href="{{ route('student.course-registration') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('student.course-registration') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
                <svg class="w-5 h-5 {{ request()->routeIs('student.course-registration') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                <span class="text-[0.95rem]">Course Registration</span>
            </a>

            <a href="{{ route('student.results') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('student.results') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
                <svg class="w-5 h-5 {{ request()->routeIs('student.results') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                <span class="text-[0.95rem]">My Results</span>
            </a>
        @endrole

        @role('lecturer|admin')
            <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-3 mt-6">Grading</p>
            
            <a href="{{ route('lecturer.result-upload') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('lecturer.result-upload') ? 'bg-white/20 text-white font-semibold shadow-inner border border-white/10' : 'text-white/80 hover:bg-white/10 hover:text-white' }}" wire:navigate>
                <svg class="w-5 h-5 {{ request()->routeIs('lecturer.result-upload') ? 'text-blue-400' : 'opacity-70' }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="M8 18v-1"/><path d="M16 18v-3"/></svg>
                <span class="text-[0.95rem]">Result Upload</span>
            </a>
        @endrole
    </nav>

    <!-- Sidebar Footer (Profile / Logout) -->
    <div class="relative z-10 p-4 border-t border-white/10">
        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition-all duration-200" wire:navigate>
            <svg class="w-5 h-5 opacity-70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
            <span class="text-[0.95rem]">Account Settings</span>
        </a>
        
        <button wire:click="logout" class="w-full mt-2 flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-500/20 hover:text-red-200 transition-all duration-200">
            <svg class="w-5 h-5 opacity-80" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
            <span class="text-[0.95rem] font-medium">Sign Out</span>
        </button>
    </div>
</aside>

<!-- Mobile Overlay -->
<div 
    x-show="sidebarOpen" 
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm lg:hidden"
    style="display: none;">
</div>
</div>
