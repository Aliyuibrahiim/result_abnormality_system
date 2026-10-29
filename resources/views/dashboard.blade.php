<x-app-layout>
    <x-slot name="header">
        Welcome to your Dashboard
    </x-slot>

    <div class="py-4">
        <!-- Welcome Card -->
        <div class="glass-card p-6 md:p-8 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 brand-font">Hello, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-slate-500 mb-0">Welcome to the KASU Result Tracking System. From here you can manage your academic profile.</p>
                </div>
                <div class="flex-shrink-0">
                    <span class="badge-abu">{{ auth()->user()->roles->first()->name ?? 'Student' }} Account</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid (Placeholder for later data) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @role('admin')
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-green);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Users</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">{{\App\Models\User::count()}}</h4>
                </div>
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-emerald);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Courses</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">--</h4>
                </div>
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-slate);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Active Session</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">2026/2027</h4>
                </div>
            @else
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-green);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Current CGPA</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">--</h4>
                </div>
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-emerald);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Units</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">--</h4>
                </div>
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-slate);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Active Session</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">2026/2027</h4>
                </div>
            @endrole
        </div>
    </div>
</x-app-layout>
