<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public $code = '';
    public $title = '';
    public $unit_load = '';
    public $coordinator_id = '';

    public function save()
    {
        $this->validate([
            'code' => 'required|string|max:20|unique:courses,code',
            'title' => 'required|string|max:255',
            'unit_load' => 'required|integer|min:1|max:6',
            'coordinator_id' => 'nullable|exists:users,id',
        ]);

        Course::create([
            'code' => strtoupper($this->code),
            'title' => $this->title,
            'unit_load' => $this->unit_load,
            'coordinator_id' => $this->coordinator_id ?: null,
        ]);

        session()->flash('message', 'Course created successfully.');
        return $this->redirectRoute('admin.courses', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.courses.create', [
            'lecturers' => User::role('lecturer')->get(),
        ])->layout('layouts.app');
    }
}
