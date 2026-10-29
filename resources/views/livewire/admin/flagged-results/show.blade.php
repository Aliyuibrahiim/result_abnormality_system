<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
        
        <!-- Details Column -->
        <div class="w-full md:w-1/2 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg glass-card">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 border-b pb-4 mb-4">Abnormality Details</h3>
                    
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Student Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $flaggedResult->result->student->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Course</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $flaggedResult->result->course->code }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Abnormality Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold text-red-600">{{ $flaggedResult->abnormality_type }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Severity</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">
                                @if ($flaggedResult->severity === 'High')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">High</span>
                                @elseif ($flaggedResult->severity === 'Medium')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Medium</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $flaggedResult->severity }}</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg glass-card">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 border-b pb-4 mb-4">Result Data</h3>
                    
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <span class="block text-xs font-medium text-gray-500 uppercase tracking-wide">CA Score</span>
                            <span class="block text-2xl font-bold text-slate-800 mt-1">{{ $flaggedResult->result->ca_score ?? '-' }}</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <span class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Exam Score</span>
                            <span class="block text-2xl font-bold text-slate-800 mt-1">{{ $flaggedResult->result->exam_score ?? '-' }}</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <span class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Total</span>
                            <span class="block text-2xl font-bold text-blue-600 mt-1">{{ $flaggedResult->result->total_score }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Column -->
        <div class="w-full md:w-1/2 space-y-6">
            
            @if(session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg glass-card">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-slate-800 border-b pb-4 mb-4">Log Resolution</h3>
                    
                    @if ($flaggedResult->is_resolved)
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <p class="text-sm text-green-700 font-semibold">
                                        This flag has been marked as resolved.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form wire:submit="logResolution">
                        <div class="mb-4">
                            <label for="resolution_status" class="block text-sm font-medium text-gray-700">Action</label>
                            <select wire:model.live="resolution_status" id="resolution_status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="approved">Approve Result (False Alarm)</option>
                                <option value="correct_score">Correct the Scores</option>
                                <option value="investigating">Currently Investigating</option>
                                <option value="rejected">Reject Result (Requires Lecturer Action)</option>
                            </select>
                            @error('resolution_status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        @if($resolution_status === 'correct_score')
                            <div class="mb-4 grid grid-cols-2 gap-4">
                                <div>
                                    <label for="new_ca_score" class="block text-sm font-medium text-gray-700">Correct CA Score (Max 30)</label>
                                    <input type="number" wire:model="new_ca_score" id="new_ca_score" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('new_ca_score') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="new_exam_score" class="block text-sm font-medium text-gray-700">Correct Exam Score (Max 70)</label>
                                    <input type="number" wire:model="new_exam_score" id="new_exam_score" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @error('new_exam_score') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="review_notes" class="block text-sm font-medium text-gray-700">Review Notes</label>
                            <textarea wire:model="review_notes" id="review_notes" rows="4" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Explain the findings or resolution..."></textarea>
                            @error('review_notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full btn-primary justify-center">
                            Submit Log
                        </button>
                    </form>
                </div>
            </div>

            <!-- Log History -->
            @if ($logs->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg glass-card">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-800 border-b pb-4 mb-4">Resolution History</h3>
                    <ul class="space-y-4">
                        @foreach ($logs as $log)
                            <li class="bg-gray-50 rounded p-3 text-sm border border-gray-100">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-gray-800">{{ $log->reviewer->name ?? 'Admin' }}</span>
                                    <span class="text-xs text-gray-500">{{ $log->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold bg-gray-200 text-gray-800 mb-2">
                                    {{ ucfirst($log->resolution_status) }}
                                </span>
                                <p class="text-gray-700 mt-1">{{ $log->review_notes }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
