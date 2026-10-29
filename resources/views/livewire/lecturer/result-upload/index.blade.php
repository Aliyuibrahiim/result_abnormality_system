<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-card shadow-sm sm:rounded-[1.25rem] p-6 lg:p-8">
            <div class="mb-6 border-b pb-4">
                <h3 class="text-[1.75rem] font-bold text-gray-900 font-outfit">Result Upload</h3>
                @if ($activeSession)
                    <p class="text-gray-500 text-[0.875rem] mt-1">
                        Uploading for <strong>{{ $activeSession->name }}</strong> -
                        {{ $activeSession->semester == 1 ? 'First Semester' : 'Second Semester' }}
                    </p>
                @else
                    <p class="text-sm text-red-600 font-medium mt-1">No active academic session.</p>
                @endif
            </div>

            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm">
                    <p class="font-medium">{{ session('message') }}</p>
                </div>
            @endif

            @if ($activeSession)
                <div class="mb-8">
                    <label for="course" class="block text-sm font-semibold text-gray-700 mb-2">Select Course to Grade</label>
                    <select wire:model.live="selectedCourseId" id="course"
                        class="block w-full md:w-1/2 py-2.5 px-4 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] transition-colors">
                        <option value="">-- Select Course --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($selectedCourseId)
                    @if (count($students) > 0)
                        <form wire:submit.prevent="saveResults">
                            <div class="overflow-x-auto bg-white rounded-xl border border-gray-100 shadow-sm mb-6">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Student Name</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Matric Number</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                CA Score (Max 30)</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                Exam Score (Max 70)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach ($students as $student)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-bold text-gray-900">{{ $student->first_name }} {{ $student->last_name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-500">{{ $student->matric_no }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" step="0.1" min="0" max="30" wire:model="scores.{{ $student->id }}.ca"
                                                        class="focus:ring-[#2563EB] focus:border-[#2563EB] block w-24 sm:text-sm border-gray-300 rounded-lg shadow-sm">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" step="0.1" min="0" max="70" wire:model="scores.{{ $student->id }}.exam"
                                                        class="focus:ring-[#2563EB] focus:border-[#2563EB] block w-24 sm:text-sm border-gray-300 rounded-lg shadow-sm">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="flex justify-end border-t border-gray-100 pt-6">
                                <button type="submit" class="btn-primary shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    Save & Analyze Results
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mt-4 p-6 bg-slate-50 border border-slate-100 rounded-xl text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <h3 class="text-lg font-medium text-slate-900 mb-1">No Students Registered</h3>
                            <p class="text-sm text-slate-500">There are currently no students registered for this course in the active session.</p>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>
