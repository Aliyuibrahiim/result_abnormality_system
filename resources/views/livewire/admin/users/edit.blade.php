<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg glass-card">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between mb-6 border-b pb-4">
                    <h3 class="text-xl font-bold text-[#2563EB]">Edit User: {{ $name }}</h3>
                    <a href="{{ route('admin.users') }}" class="text-gray-500 hover:text-gray-700" wire:navigate>
                        Back to Users
                    </a>
                </div>

                <form wire:submit.prevent="save">
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" wire:model="name" id="name" class="mt-1 focus:ring-[#2563EB] focus:border-[#2563EB] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input type="email" wire:model="email" id="email" class="mt-1 focus:ring-[#2563EB] focus:border-[#2563EB] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select wire:model="role" id="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2563EB] focus:border-[#2563EB] sm:text-sm">
                                <option value="">Select a role</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->name }}">{{ ucfirst(str_replace('_', ' ', $r->name)) }}</option>
                                @endforeach
                            </select>
                            @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password (Leave blank to keep current)</label>
                            <input type="password" wire:model="password" id="password" class="mt-1 focus:ring-[#2563EB] focus:border-[#2563EB] block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_active" wire:model="is_active" type="checkbox" class="focus:ring-[#2563EB] h-4 w-4 text-[#2563EB] border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700">Active Account</label>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="btn-primary">
                                Update User
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
