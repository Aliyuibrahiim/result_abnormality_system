<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Course;
use App\Models\AcademicSession;

class Dashboard extends Component
{
    public $totalUsers = 0;
    public $totalCourses = 0;
    public $activeSessionName = 'None';
    public $cgpa = 0.0;
    public $totalUnits = 0;
    public $unresolvedFlags = 0;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->totalCourses = Course::count();
        
        $session = AcademicSession::where('is_active', true)->first();
        if ($session) {
            $this->activeSessionName = $session->name . ' (' . ($session->semester == 1 ? 'First' : 'Second') . ' Semester)';
        }

        if (auth()->user()->hasRole(['admin', 'exam_officer'])) {
            $this->unresolvedFlags = \App\Models\FlaggedResult::where('is_resolved', false)->count();
        }

        if (auth()->user()->hasRole('student')) {
            $studentId = auth()->user()->student->id ?? null;
            $allResults = \App\Models\Result::with('course')->where('student_id', $studentId)->get();
            $totalPoints = 0;
            foreach ($allResults as $result) {
                $units = $result->course->unit_load;
                $this->totalUnits += $units;
                $totalPoints += ($result->points * $units);
            }
            if ($this->totalUnits > 0) {
                $this->cgpa = round($totalPoints / $this->totalUnits, 2);
            }
        }
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }
}
