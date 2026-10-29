<?php

namespace App\Livewire\Admin\AcademicSessions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AcademicSession;

class Index extends Component
{
    use WithPagination;

    public function toggleActive($id)
    {
        $session = AcademicSession::findOrFail($id);
        
        if (!$session->is_active) {
            AcademicSession::where('id', '!=', $id)->update(['is_active' => false]);
            $session->update(['is_active' => true]);
            session()->flash('message', 'Academic session activated.');
        } else {
            $session->update(['is_active' => false]);
            session()->flash('message', 'Academic session deactivated.');
        }
    }

    public function delete($id)
    {
        $session = AcademicSession::findOrFail($id);
        
        if ($session->is_active) {
            session()->flash('error', 'Cannot delete an active academic session.');
            return;
        }

        $session->delete();
        session()->flash('message', 'Academic session deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.academic-sessions.index', [
            'sessions' => AcademicSession::orderBy('created_at', 'desc')->paginate(10),
        ])->layout('layouts.app');
    }
}
