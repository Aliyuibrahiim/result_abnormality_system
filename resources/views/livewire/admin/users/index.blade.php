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
                    <h3 class="text-[1.75rem] font-bold text-gray-900 font-outfit">User Management</h3>
                    <p class="text-gray-500 text-[0.875rem] mt-1">Manage platform users, roles, and account statuses.</p>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn-primary" wire:navigate>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add User
                </a>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-gray-100 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Roles</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach ($user->roles as $role)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->is_active)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-3" wire:navigate>Edit</a>
                                        <button wire:click="toggleActive({{ $user->id }})"
                                            class="{{ $user->is_active ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }} mr-3">
                                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                        <button wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?" class="text-red-600 hover:text-red-900">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
        </div>
    </div>
</div>
