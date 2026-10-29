<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="glass-card shadow-sm sm:rounded-[1.25rem] p-6 lg:p-8">
            @if (session()->has('message'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm">
                    <p class="font-medium">{{ session('message') }}</p>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 border-b pb-4">
                <div>
                    <h3 class="text-[1.75rem] font-bold text-gray-900 font-outfit">Course Management</h3>
                    <p class="text-gray-500 text-[0.875rem] mt-1">Manage all available courses, titles, and assigned lecturers.</p>
                </div>
                <a href="{{ route('admin.courses.create') }}" class="btn-primary" wire:navigate>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Course
                </a>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-100 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Units</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Coordinator</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($courses as $course)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $course->code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->unit_load }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($course->coordinator)
                                                {{ $course->coordinator->name }}
                                            @else
                                                <span class="text-gray-400 italic">None</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.courses.edit', $course) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" wire:navigate>Edit</a>
                                            <button wire:click="delete({{ $course->id }})" wire:confirm="Are you sure you want to delete this course?" class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $courses->links() }}
                    </div>
        </div>
    </div>
</div>
