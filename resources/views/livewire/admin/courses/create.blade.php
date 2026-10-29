<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg glass-card">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between mb-6 border-b pb-4">
                    <h3 class="text-xl font-bold text-[#2563EB]">Add New Course</h3>
                    <a href="{{ route('admin.courses') }}" class="text-gray-500 hover:text-gray-700" wire:navigate>
                        Back to Courses
                    </a>
                </div>

                <form wire:submit.prevent="save">
                    <div class="space-y-6">
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">Course Code</label>
                            <input type="text" wire:model="code" id="code" placeholder="e.g. CSC101"
                                class="mt-1 uppercase focus:ring-[#2563EB] focus:border-[#2563EB] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('code')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Course Title</label>
                            <input type="text" wire:model="title" id="title"
                                placeholder="Introduction to Computer Science"
                                class="mt-1 focus:ring-[#2563EB] focus:border-[#2563EB] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('title')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="unit_load" class="block text-sm font-medium text-gray-700">Credit Units</label>
                            <select wire:model="unit_load" id="unit_load"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2563EB] focus:border-[#2563EB] sm:text-sm">
                                <option value="">Select Units</option>
                                @for ($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('unit_load')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="coordinator_id" class="block text-sm font-medium text-gray-700">Assign Lecturer
                                (Coordinator)</label>
                            <select wire:model="coordinator_id" id="coordinator_id"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2563EB] focus:border-[#2563EB] sm:text-sm">
                                <option value="">Select Lecturer</option>
                                @foreach ($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                                @endforeach
                            </select>
                            @error('coordinator_id')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="btn-primary">
                                Create Course
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
