<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $userId;
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = '';
    public $is_active = true;

    public function mount(User $user)
    {
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_active = $user->is_active;
        $this->role = $user->roles->first()->name ?? '';
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->userId)],
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->is_active = $this->is_active;

        if (!empty($this->password)) {
            $this->validate(['password' => 'min:8']);
            $user->password = Hash::make($this->password);
        }

        $user->save();
        $user->syncRoles([$this->role]);

        session()->flash('message', 'User updated successfully.');
        return $this->redirectRoute('admin.users', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.users.edit', [
            'roles' => Role::all(),
        ])->layout('layouts.app');
    }
}
