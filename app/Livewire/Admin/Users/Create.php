<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = '';
    public $is_active = true;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_active' => $this->is_active,
        ]);

        $user->assignRole($this->role);

        session()->flash('message', 'User created successfully.');
        return $this->redirectRoute('admin.users', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.users.create', [
            'roles' => Role::all(),
        ])->layout('layouts.app');
    }
}
