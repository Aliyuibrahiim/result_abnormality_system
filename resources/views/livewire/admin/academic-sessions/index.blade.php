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
                    <h3 class="text-[1.75rem] font-bold text-gray-900 font-outfit">Academic Sessions</h3>
                    <p class="text-gray-500 text-[0.875rem] mt-1">Manage academic sessions and set the active semester.</p>
                </div>
                <a href="{{ route('admin.academic-sessions.create') }}" class="btn-primary" wire:navigate>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Session
                </a>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-100 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Semester</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $session->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $session->semester == 1 ? 'First' : 'Second' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($session->is_active)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Current</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.academic-sessions.edit', $session) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" wire:navigate>Edit</a>
                                            
                                            @if (!$session->is_active)
                                                <button wire:click="toggleActive({{ $session->id }})" wire:confirm="Are you sure you want to set this as the active session?" class="text-green-600 hover:text-green-900 mr-3">Set Active</button>
                                            @endif
                                            
                                            <button wire:click="delete({{ $session->id }})" wire:confirm="Are you sure you want to delete this session?" class="text-red-600 hover:text-red-900" {{ $session->is_active ? 'disabled' : '' }}>Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $sessions->links() }}
                    </div>
        </div>
    </div>
</div>
