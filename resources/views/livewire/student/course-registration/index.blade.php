<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if (session()->has('message'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-6">
                    <h3 class="text-xl font-bold">Course Registration</h3>
                    @if ($activeSession)
                        <p class="text-sm text-gray-600">
                            Registering for <strong>{{ $activeSession->name }}</strong> - 
                            {{ $activeSession->semester == 1 ? 'First Semester' : 'Second Semester' }}
                        </p>
                    @else
                        <p class="text-sm text-red-600 font-medium">No active academic session. Please contact the administrator.</p>
                    @endif
                </div>

                @if ($activeSession)
                    <form wire:submit.prevent="registerCourses">
                        <div class="overflow-x-auto border rounded-lg border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Code</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($courses as $course)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" wire:model="selectedCourses" value="{{ $course->id }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $course->code }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $course->title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $course->unit_load }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No courses available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow transition duration-150 ease-in-out">
                                Save Registration
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
