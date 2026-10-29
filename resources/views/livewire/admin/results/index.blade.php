<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-card shadow-sm sm:rounded-[1.25rem] p-6 lg:p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-[1.75rem] font-bold text-gray-900 font-outfit">All Global Results</h3>
                    <p class="text-gray-500 text-[0.875rem]">View all submitted results across all courses and sessions.
                    </p>
                </div>
            </div>

            <div class="mb-6 flex flex-col md:flex-row gap-4">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Search by student name, email, or course code..."
                    class="w-full md:w-1/3 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5">
                
                <select wire:model.live="lecturer_id" class="w-full md:w-1/3 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5">
                    <option value="">-- Filter by Lecturer --</option>
                    @foreach($lecturers as $lecturer)
                        <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="course_id" class="w-full md:w-1/3 rounded-xl border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] py-2.5" {{ empty($courses) ? 'disabled' : '' }}>
                    <option value="">-- Filter by Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-100 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Student</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Course</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Session</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Scores (CA / Exam)</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Total & Grade</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($results as $result)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $result->student->first_name }}
                                        {{ $result->student->last_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $result->student->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $result->course->code }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $result->academicSession->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                    <span class="text-gray-500 text-xs uppercase">CA:</span>
                                    {{ $result->ca_score ?? '-' }}
                                    <span class="text-gray-300 mx-1">|</span>
                                    <span class="text-gray-500 text-xs uppercase">Exam:</span>
                                    {{ $result->exam_score ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $result->total_score ?? '-' }}</div>
                                    <div class="text-xs text-[#2563EB] font-bold">Grade: {{ $result->grade ?? '-' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No results found matching your search.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $results->links() }}
            </div>
        </div>
    </div>
</div>
