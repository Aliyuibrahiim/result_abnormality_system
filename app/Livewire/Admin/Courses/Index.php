<?php

namespace App\Livewire\Admin\Courses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Course;
use App\Models\User;

class Index extends Component
{
    use WithPagination;

    public function toggleActive($id)
    {
        $course = Course::findOrFail($id);
        $course->update(['is_active' => !$course->is_active]);
        session()->flash('message', 'Course status updated.');
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        session()->flash('message', 'Course deleted successfully.');
    }

    public function render()
    {
        // Get users who are lecturers for the coordinator dropdown
        $lecturers = User::role('lecturer')->get();

        return view('livewire.admin.courses.index', [
            'courses' => Course::with('coordinator')->paginate(10),
            'lecturers' => $lecturers,
        ])->layout('layouts.app');
    }
}
