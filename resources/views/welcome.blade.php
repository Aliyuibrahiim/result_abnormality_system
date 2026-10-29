<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Result Tracking System') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-[#334155] antialiased bg-[#F8FAFC] h-screen overflow-hidden">
    <div class="flex h-screen w-full">
        <!-- Left Sidebar (Hero Banner) -->
        <div class="hidden lg:flex lg:w-1/2 relative flex-col justify-between overflow-hidden p-12 text-white" style="background: linear-gradient(135deg, #1E3A8A 0%, #2563EB 40%, #0F172A 100%);">
            <!-- Background Decoration -->
            <div class="absolute inset-0 z-0">
                <div class="absolute -top-[50%] -right-[50%] w-full h-full rounded-full z-0" style="background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);"></div>
            </div>
            
            <!-- Top Content -->
            <div class="relative z-10 flex flex-col items-start gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-[54px] h-[54px] bg-white rounded-full flex items-center justify-center shadow-[0_4px_12px_rgba(0,0,0,0.15)]">
                        <svg class="w-8 h-8 text-[#2563EB]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a2 2 0 0 1-.019 3.138l-4.04 3.737-1.127.911a2 2 0 0 1-2.474 0l-1.127-.911-4.04-3.737a2 2 0 0 1-.019-3.138l8.28-7.08a2 2 0 0 1 2.583 0z"/><path d="M12 18.5V22"/><path d="M8.5 15.5v3.66a2 2 0 0 0 1 1.73l2 1.15a2 2 0 0 0 2 0l2-1.15a2 2 0 0 0 1-1.73V15.5"/><path d="m3 11 9-8 9 8-9 8-9-8Z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-[1.25rem] font-bold text-white mb-0" style="font-family: 'Outfit', sans-serif;">RESULT SYSTEM</h2>
                        <p class="text-white/75 text-sm font-medium mb-0">Result Tracking System</p>
                    </div>
                </div>
                
                <span class="mt-4 inline-block px-3 py-1.5 rounded-full border text-xs font-semibold tracking-wide uppercase" style="background-color: rgba(16, 185, 129, 0.2); color: #10B981; border-color: rgba(16, 185, 129, 0.3);">
                    Academic Portal
                </span>
                
                <h1 class="mt-3 text-[2.5rem] font-bold text-white leading-[1.2]" style="font-family: 'Outfit', sans-serif;">
                    Intelligent Result Tracking & Analytics
                </h1>
                
                <p class="mt-4 text-lg text-white/90 max-w-lg leading-[1.7]">
                    A secure, data-driven platform for tracking academic performance, accessing results in real-time, and generating comprehensive analytical reports.
                </p>
                
                <div class="grid grid-cols-2 gap-8 mt-12 pt-8 border-t border-white/10 w-full max-w-xl">
                    <div class="flex items-center gap-3">
                        <div class="p-3 rounded-[0.75rem] bg-white/10">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="16" x="4" y="4" rx="2"/><rect width="6" height="6" x="9" y="9" rx="1"/><path d="M15 2v2"/><path d="M15 20v2"/><path d="M2 15h2"/><path d="M2 9h2"/><path d="M20 15h2"/><path d="M20 9h2"/><path d="M9 2v2"/><path d="M9 20v2"/></svg>
                        </div>
                        <div>
                            <h6 class="mb-0 text-white font-bold text-sm">Smart Analytics</h6>
                            <small class="text-white/75 text-[0.75rem]">Data-driven tracking</small>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-3 rounded-[0.75rem] bg-white/10">
                            <svg class="w-6 h-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                        <div>
                            <h6 class="mb-0 text-white font-bold text-sm">Real-time Portal</h6>
                            <small class="text-white/75 text-[0.75rem]">Access your grades instantly</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Content -->
            <div class="relative z-10 flex justify-between items-center pt-6 border-t border-white/10 mt-8">
                <p class="text-sm text-white/75">
                    &copy; {{ date('Y') }} Kaduna State University.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-white/75 hover:text-white transition-colors text-sm">Privacy</a>
                    <a href="#" class="text-white/75 hover:text-white transition-colors text-sm">Terms</a>
                </div>
            </div>
        </div>
        
        <!-- Right Content (Welcome Form/Actions) -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 bg-[#F8FAFC] relative overflow-y-auto">
            
            <!-- Mobile Header (Visible only on small screens) -->
            <div class="lg:hidden text-center mb-8 w-full flex flex-col items-center">
                <div class="w-[54px] h-[54px] bg-[#2563EB] rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a2 2 0 0 1-.019 3.138l-4.04 3.737-1.127.911a2 2 0 0 1-2.474 0l-1.127-.911-4.04-3.737a2 2 0 0 1-.019-3.138l8.28-7.08a2 2 0 0 1 2.583 0z"/><path d="M12 18.5V22"/><path d="M8.5 15.5v3.66a2 2 0 0 0 1 1.73l2 1.15a2 2 0 0 0 2 0l2-1.15a2 2 0 0 0 1-1.73V15.5"/><path d="m3 11 9-8 9 8-9 8-9-8Z"/></svg>
                </div>
                <h3 class="text-[1.75rem] font-bold text-gray-900 mb-1" style="font-family: 'Outfit', sans-serif;">RESULT SYSTEM</h3>
                <p class="text-gray-500 mt-0">Result Tracking System</p>
            </div>
            
            <div class="w-full" style="max-width: 440px;">
                <div class="p-8 lg:p-10 rounded-[1.25rem] border" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-color: rgba(226, 232, 240, 0.8); box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);">
                    <div class="text-center mb-8 hidden lg:block">
                        <h2 class="text-[1.75rem] font-bold text-gray-900 mb-1" style="font-family: 'Outfit', sans-serif;">Welcome Back</h2>
                        <p class="text-gray-500 text-[0.875rem]">Sign in to your student or admin account.</p>
                    </div>
                    
                    <div class="flex flex-col gap-5">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-white font-semibold shadow-[0_4px_12px_rgba(0,102,51,0.25)] transition-all hover:-translate-y-[1px] hover:shadow-[0_6px_16px_rgba(0,102,51,0.35)] text-decoration-none" style="background: linear-gradient(135deg, #2563EB, #1D4ED8);">
                                Proceed to Dashboard
                                <svg class="w-[18px] h-[18px] ml-1 transition-transform group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl text-white font-semibold shadow-[0_4px_12px_rgba(0,102,51,0.25)] transition-all hover:-translate-y-[1px] hover:shadow-[0_6px_16px_rgba(0,102,51,0.35)] text-decoration-none" style="background: linear-gradient(135deg, #2563EB, #1D4ED8);">
                                Sign In to Portal
                                <svg class="w-[18px] h-[18px] ml-1 transition-transform group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </a>
                            
                            @if (Route::has('register'))
                                <div class="relative mt-2 mb-2">
                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                        <div class="w-full border-t border-gray-200"></div>
                                    </div>
                                    <div class="relative flex justify-center text-[0.875rem] font-medium leading-6">
                                        <span class="px-4 text-gray-500" style="background: rgba(255, 255, 255, 0.85);">New student?</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('register') }}" class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl font-semibold transition-all hover:bg-[#2563EB] hover:text-white text-decoration-none" style="border: 2px solid #2563EB; color: #2563EB; background: transparent;">
                                    Create an account
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <div class="mt-8 text-center w-full max-w-md">
                    <small class="text-gray-500">Need help? Contact ICT Center at <a href="mailto:ict@kasu.edu.ng" class="text-decoration-none text-gray-700">ict@kasu.edu.ng</a></small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
