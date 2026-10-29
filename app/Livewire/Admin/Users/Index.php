<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        session()->flash('message', 'User status updated.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.users.index', [
            'users' => User::with('roles')->paginate(10),
            'roles' => Role::all(),
        ])->layout('layouts.app');
    }
}
