<?php

namespace App\Livewire\Admin\AcademicSessions;

use App\Models\AcademicSession;
use Livewire\Component;

class Edit extends Component
{
    public $sessionId;
    public $name = '';
    public $semester = '';
    public $is_active = false;

    public function mount(AcademicSession $academicSession)
    {
        $this->sessionId = $academicSession->id;
        $this->name = $academicSession->name;
        $this->semester = $academicSession->semester;
        $this->is_active = $academicSession->is_active;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:50',
            'semester' => 'required|integer|in:1,2',
        ]);

        if ($this->is_active) {
            AcademicSession::where('id', '!=', $this->sessionId)->update(['is_active' => false]);
        }

        $session = AcademicSession::findOrFail($this->sessionId);
        $session->update([
            'name' => $this->name,
            'semester' => $this->semester,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Academic Session updated successfully.');
        return $this->redirectRoute('admin.academic-sessions', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.academic-sessions.edit')->layout('layouts.app');
    }
}
