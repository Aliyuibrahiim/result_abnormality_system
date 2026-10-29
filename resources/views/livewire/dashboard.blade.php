<div>
    <x-slot name="header">
        Welcome to your Dashboard
    </x-slot>

    <div class="py-4">
        <!-- Welcome Card -->
        <div class="glass-card p-6 md:p-8 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2 brand-font">Hello, {{ auth()->user()->name }}! 👋
                    </h3>
                    <p class="text-slate-500 mb-0">Welcome to the KASU Result Tracking System. From here you can manage
                        your academic profile.</p>
                </div>
                <div class="flex-shrink-0">
                    <span class="badge-abu">{{ auth()->user()->roles->first()->name ?? 'Student' }} Account</span>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @hasanyrole('admin|exam_officer')
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-green);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Users</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">{{ $totalUsers }}</h4>
                </div>
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-emerald);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Courses</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">{{ $totalCourses }}</h4>
                </div>
                
                @if($unresolvedFlags > 0)
                <div class="glass-card p-6 border-l-4 bg-red-50/50" style="border-left-color: #ef4444;">
                    <p class="text-sm font-semibold text-red-500 uppercase tracking-wider mb-1">Unresolved Flags</p>
                    <h4 class="text-3xl font-bold text-red-600 brand-font">{{ $unresolvedFlags }}</h4>
                </div>
                @else
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-slate);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Active Session</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font text-xl">{{ $activeSessionName }}</h4>
                </div>
                @endif
            @endhasanyrole
            
            @role('student')
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-green);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Current CGPA</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">{{ number_format($cgpa, 2) }}</h4>
                </div>
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-emerald);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Total Units Earned</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font">{{ $totalUnits }}</h4>
                </div>
                <div class="glass-card p-6 border-l-4" style="border-left-color: var(--abu-slate);">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1">Active Session</p>
                    <h4 class="text-3xl font-bold text-slate-800 brand-font text-xl">{{ $activeSessionName }}</h4>
                </div>
            @endrole
        </div>
    </div>

    @role('student')
        <!-- Quick Actions for Students -->
        <div class="mt-8">
            <h4 class="text-xl font-bold text-slate-800 mb-4 brand-font">Quick Actions</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('student.course-registration') }}"
                    class="glass-card p-6 flex items-center justify-between hover:bg-slate-50 transition-colors group cursor-pointer"
                    style="text-decoration: none;">
                    <div>
                        <h5 class="font-bold text-lg text-slate-800 group-hover:text-[#2563EB] mb-1">Course Registration
                        </h5>
                        <p class="text-slate-500 text-sm mb-0">Select and register for your courses for the active academic
                            session.</p>
                    </div>
                    <div class="text-gray-400 group-hover:text-[#2563EB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
                <a href="{{ route('student.results') }}"
                    class="glass-card p-6 flex items-center justify-between hover:bg-slate-50 transition-colors group cursor-pointer"
                    style="text-decoration: none;">
                    <div>
                        <h5 class="font-bold text-lg text-slate-800 group-hover:text-[#2563EB] mb-1">My Results</h5>
                        <p class="text-slate-500 text-sm mb-0">View your uploaded results and academic standing.</p>
                    </div>
                    <div class="text-gray-400 group-hover:text-[#2563EB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    @endrole

    @role('exam_officer')
        <!-- Quick Actions for Exam Officer -->
        <div class="mt-8">
            <h4 class="text-xl font-bold text-slate-800 mb-4 brand-font">Quick Actions</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.abnormalities') }}"
                    class="glass-card p-6 flex items-center justify-between hover:bg-slate-50 transition-colors group cursor-pointer"
                    style="text-decoration: none;">
                    <div>
                        <h5 class="font-bold text-lg text-slate-800 group-hover:text-[#2563EB] mb-1">Result Abnormalities
                            Queue</h5>
                        <p class="text-slate-500 text-sm mb-0">Review and resolve flagged results and score anomalies.</p>
                    </div>
                    <div class="text-gray-400 group-hover:text-[#2563EB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
                <a href="{{ route('admin.results') }}"
                    class="glass-card p-6 flex items-center justify-between hover:bg-slate-50 transition-colors group cursor-pointer"
                    style="text-decoration: none;">
                    <div>
                        <h5 class="font-bold text-lg text-slate-800 group-hover:text-[#2563EB] mb-1">All Results</h5>
                        <p class="text-slate-500 text-sm mb-0">View all uploaded results across departments.</p>
                    </div>
                    <div class="text-gray-400 group-hover:text-[#2563EB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    @endrole
    @role('lecturer')
        <!-- Quick Actions for Lecturer -->
        <div class="mt-8">
            <h4 class="text-xl font-bold text-slate-800 mb-4 brand-font">Lecturer Actions</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('lecturer.result-upload') }}"
                    class="glass-card p-6 flex items-center justify-between hover:bg-slate-50 transition-colors group cursor-pointer"
                    style="text-decoration: none;">
                    <div>
                        <h5 class="font-bold text-lg text-slate-800 group-hover:text-[#2563EB] mb-1">Result Upload</h5>
                        <p class="text-slate-500 text-sm mb-0">Select your courses and enter CA and Exam scores for students.</p>
                    </div>
                    <div class="text-gray-400 group-hover:text-[#2563EB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    @endrole
</div>
</div>
