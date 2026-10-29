<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public $courseId;
    public $code = '';
    public $title = '';
    public $unit_load = '';
    public $coordinator_id = '';

    public function mount(Course $course)
    {
        $this->courseId = $course->id;
        $this->code = $course->code;
        $this->title = $course->title;
        $this->unit_load = $course->unit_load;
        $this->coordinator_id = $course->coordinator_id;
    }

    public function save()
    {
        $this->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($this->courseId)],
            'title' => 'required|string|max:255',
            'unit_load' => 'required|integer|min:1|max:6',
            'coordinator_id' => 'nullable|exists:users,id',
        ]);

        $course = Course::findOrFail($this->courseId);
        $course->update([
            'code' => strtoupper($this->code),
            'title' => $this->title,
            'unit_load' => $this->unit_load,
            'coordinator_id' => $this->coordinator_id ?: null,
        ]);

        session()->flash('message', 'Course updated successfully.');
        return $this->redirectRoute('admin.courses', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.courses.edit', [
            'lecturers' => User::role('lecturer')->get(),
        ])->layout('layouts.app');
    }
}
