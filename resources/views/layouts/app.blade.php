<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Result Tracking System') }}</title>

    <!-- Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        :root {
            --abu-green: #2563EB;
            --abu-dark-green: #1D4ED8;
            --abu-emerald: #10B981;
            --abu-slate: #0F172A;
            --abu-light-slate: #1E293B;
            --abu-bg: #F8FAFC;
            --abu-card-bg: rgba(255, 255, 255, 0.85);
            --abu-border: rgba(226, 232, 240, 0.8);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--abu-bg);
            color: #334155;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        /* Glassmorphism */
        .glass-card {
            background: var(--abu-card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--abu-border);
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        /* Custom Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--abu-green), var(--abu-dark-green));
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 102, 51, 0.25);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--abu-dark-green), #00331a);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 102, 51, 0.35);
        }

        .btn-primary-outline {
            border: 2px solid var(--abu-green);
            color: var(--abu-green);
            font-weight: 600;
            padding: 0.65rem 1.5rem;
            border-radius: 0.75rem;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-primary-outline:hover {
            background: var(--abu-green);
            color: #fff;
        }
        
        .badge-abu {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10B981;
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 0.4rem 0.8rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F8FAFC]">
    
    <div class="flex h-screen overflow-hidden bg-[#F8FAFC]" x-data="{ sidebarOpen: false }">
        
        <!-- Sidebar Navigation -->
        <livewire:layout.navigation />

        <!-- Main Content Area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            
            <!-- Header (Mobile Top Bar & Page Title) -->
            <header class="sticky top-0 z-30 flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8 bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm transition-all duration-300">
                <div class="flex items-center">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-600 lg:hidden p-2 mr-3 focus:outline-none focus:ring-2 focus:ring-[#2563EB] rounded-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    
                    @if (isset($header))
                        <div class="font-bold text-[1.25rem] text-slate-800 brand-font flex items-center">
                            {{ $header }}
                        </div>
                    @endif
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- User Dropdown (Could be moved here from navigation, but keeping simple for now) -->
                    <div class="flex items-center gap-3 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-200 shadow-sm">
                        <div class="w-8 h-8 rounded-full bg-[#2563EB] text-white flex items-center justify-center font-bold text-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-slate-700 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 leading-tight">{{ auth()->user()->roles->first()->name ?? 'Student' }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 w-full mx-auto p-4 sm:p-6 lg:p-8 max-w-7xl">
                {{ $slot }}
            </main>
            
        </div>
    </div>
    
    @livewireScripts
</body>
</html>
