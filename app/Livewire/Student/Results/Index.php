<?php

namespace App\Livewire\Student\Results;

use Livewire\Component;
use App\Models\AcademicSession;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $sessions = [];
    public $selectedSessionId;
    public $results = [];
    public $gpa = 0.0;
    public $cgpa = 0.0;

    public function mount()
    {
        $this->sessions = AcademicSession::orderBy('name', 'desc')->orderBy('semester', 'desc')->get();
        $activeSession = AcademicSession::where('is_active', true)->first();
        if ($activeSession) {
            $this->selectedSessionId = $activeSession->id;
        } elseif ($this->sessions->isNotEmpty()) {
            $this->selectedSessionId = $this->sessions->first()->id;
        }
        
        $this->loadResults();
        $this->calculateCGPA();
    }

    public function updatedSelectedSessionId()
    {
        $this->loadResults();
    }

    public function loadResults()
    {
        if ($this->selectedSessionId) {
            $this->results = Result::with('course')
                ->where('student_id', Auth::id())
                ->where('academic_session_id', $this->selectedSessionId)
                ->get();
            
            $totalUnits = 0;
            $totalPoints = 0;
            foreach ($this->results as $result) {
                $units = $result->course->unit_load;
                $totalUnits += $units;
                $totalPoints += ($result->points * $units);
            }

            $this->gpa = $totalUnits > 0 ? round($totalPoints / $totalUnits, 2) : 0.0;
        } else {
            $this->results = collect();
            $this->gpa = 0.0;
        }
    }

    public function calculateCGPA()
    {
        $allResults = Result::with('course')
            ->where('student_id', Auth::id())
            ->get();
            
        $totalUnits = 0;
        $totalPoints = 0;
        foreach ($allResults as $result) {
            $units = $result->course->unit_load;
            $totalUnits += $units;
            $totalPoints += ($result->points * $units);
        }

        $this->cgpa = $totalUnits > 0 ? round($totalPoints / $totalUnits, 2) : 0.0;
    }

    public function render()
    {
        return view('livewire.student.results.index')->layout('layouts.app');
    }
}
