<?php

namespace App\Livewire\Lecturer\ResultUpload;

use Livewire\Component;
use App\Models\Course;
use App\Models\AcademicSession;
use App\Models\CourseRegistration;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $activeSession;
    public $courses = [];
    public $selectedCourseId;
    public $students = [];
    public $scores = []; // [student_id => ['ca' => x, 'exam' => y]]

    public function mount()
    {
        $this->activeSession = AcademicSession::where('is_active', true)->first();
        
        if ($this->activeSession) {
            $this->courses = Course::where('coordinator_id', Auth::id())->get();
        }
    }

    public function updatedSelectedCourseId()
    {
        if ($this->selectedCourseId && $this->activeSession) {
            $registrations = CourseRegistration::with('student')
                ->where('course_id', $this->selectedCourseId)
                ->where('academic_session_id', $this->activeSession->id)
                ->get();
            
            $this->students = $registrations->pluck('student');

            // Load existing results if any
            $results = Result::where('course_id', $this->selectedCourseId)
                ->where('academic_session_id', $this->activeSession->id)
                ->get()
                ->keyBy('student_id');

            $this->scores = [];
            foreach ($this->students as $student) {
                if (isset($results[$student->id])) {
                    $this->scores[$student->id] = [
                        'ca' => $results[$student->id]->ca_score,
                        'exam' => $results[$student->id]->exam_score
                    ];
                } else {
                    $this->scores[$student->id] = ['ca' => '', 'exam' => ''];
                }
            }
        } else {
            $this->students = [];
            $this->scores = [];
        }
    }

    public function saveResults()
    {
        if (!$this->selectedCourseId || !$this->activeSession) {
            return;
        }

        foreach ($this->scores as $studentId => $scoreData) {
            $ca = is_numeric($scoreData['ca']) ? (float)$scoreData['ca'] : null;
            $exam = is_numeric($scoreData['exam']) ? (float)$scoreData['exam'] : null;

            if ($ca === null && $exam === null) {
                continue; // Skip if completely empty
            }

            $total = ($ca ?? 0) + ($exam ?? 0);
            
            // Basic KASU Grading logic
            $grade = 'F';
            $points = 0.0;
            if ($total >= 70) { $grade = 'A'; $points = 5.0; }
            elseif ($total >= 60) { $grade = 'B'; $points = 4.0; }
            elseif ($total >= 50) { $grade = 'C'; $points = 3.0; }
            elseif ($total >= 45) { $grade = 'D'; $points = 2.0; }
            elseif ($total >= 40) { $grade = 'E'; $points = 1.0; }

            Result::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_id' => $this->selectedCourseId,
                    'academic_session_id' => $this->activeSession->id,
                ],
                [
                    'ca_score' => $ca,
                    'exam_score' => $exam,
                    'total_score' => $total,
                    'grade' => $grade,
                    'points' => $points,
                ]
            );
        }

        // Fetch all results for the course and session to validate
        $resultsToValidate = Result::where('course_id', $this->selectedCourseId)
            ->where('academic_session_id', $this->activeSession->id)
            ->get();

        // Run Rule-based Validation
        \App\Services\ResultValidationService::validateBatch($resultsToValidate);

        // Run Statistical Abnormality Testing
        \App\Services\ResultStatisticalAnalyzer::analyzeCourseResults($this->selectedCourseId, $this->activeSession->id);

        session()->flash('message', 'Results saved successfully and all validations/analysis completed.');
    }

    public function render()
    {
        return view('livewire.lecturer.result-upload.index')->layout('layouts.app');
    }
}
