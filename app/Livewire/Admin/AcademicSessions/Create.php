<?php

namespace App\Livewire\Admin\AcademicSessions;

use App\Models\AcademicSession;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $semester = '';
    public $is_active = false;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:50',
            'semester' => 'required|integer|in:1,2',
        ]);

        if ($this->is_active) {
            AcademicSession::query()->update(['is_active' => false]);
        }

        AcademicSession::create([
            'name' => $this->name,
            'semester' => $this->semester,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Academic Session created successfully.');
        return $this->redirectRoute('admin.academic-sessions', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.academic-sessions.create')->layout('layouts.base');
    }
}
