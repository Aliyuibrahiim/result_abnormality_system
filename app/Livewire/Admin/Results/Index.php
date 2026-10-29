<?php

namespace App\Livewire\Admin\Results;

use App\Models\Result;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $lecturer_id = '';
    public $course_id = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedLecturerId()
    {
        $this->course_id = ''; // Reset course when lecturer changes
        $this->resetPage();
    }
    
    public function updatedCourseId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $lecturers = \App\Models\User::role('lecturer')->get();
        
        $courses = collect();
        if ($this->lecturer_id) {
            $courses = \App\Models\Course::where('coordinator_id', $this->lecturer_id)->get();
        }

        $query = Result::with(['student.user', 'course', 'academicSession']);
        
        if ($this->lecturer_id) {
            $query->whereHas('course', function($q) {
                $q->where('coordinator_id', $this->lecturer_id);
            });
        }
        
        if ($this->course_id) {
            $query->where('course_id', $this->course_id);
        }

        if (!empty($this->search)) {
            $query->where(function($subQuery) {
                $subQuery->whereHas('student', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function($q2) {
                          $q2->where('email', 'like', '%' . $this->search . '%')
                             ->orWhere('name', 'like', '%' . $this->search . '%');
                      });
                })->orWhereHas('course', function ($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                      ->orWhere('title', 'like', '%' . $this->search . '%');
                });
            });
        }

        return view('livewire.admin.results.index', [
            'results' => $query->orderBy('created_at', 'desc')->paginate(15),
            'lecturers' => $lecturers,
            'courses' => $courses,
        ])->layout('layouts.app');
    }
}
