<?php

namespace App\Livewire\Student\CourseRegistration;

use Livewire\Component;
use App\Models\Course;
use App\Models\AcademicSession;
use App\Models\CourseRegistration;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $activeSession;
    public $selectedCourses = [];

    public function mount()
    {
        $this->activeSession = AcademicSession::where('is_active', true)->first();
        $student = Auth::user()->student;
        
        if ($this->activeSession && $student) {
            $this->selectedCourses = CourseRegistration::where('student_id', $student->id)
                ->where('academic_session_id', $this->activeSession->id)
                ->pluck('course_id')
                ->toArray();
        }
    }

    public function registerCourses()
    {
        if (!$this->activeSession) {
            session()->flash('error', 'No active academic session found.');
            return;
        }

        $student = Auth::user()->student;
        if (!$student) {
            session()->flash('error', 'You do not have a student profile.');
            return;
        }

        $studentId = $student->id;
        $sessionId = $this->activeSession->id;

        // Get currently registered courses
        $currentlyRegistered = CourseRegistration::where('student_id', $studentId)
                ->where('academic_session_id', $sessionId)
                ->pluck('course_id')
                ->toArray();

        // Find courses to add and courses to remove
        $toAdd = array_diff($this->selectedCourses, $currentlyRegistered);
        $toRemove = array_diff($currentlyRegistered, $this->selectedCourses);

        // Add new registrations
        foreach ($toAdd as $courseId) {
            CourseRegistration::create([
                'student_id' => $studentId,
                'course_id' => $courseId,
                'academic_session_id' => $sessionId,
            ]);
        }

        // Remove unselected courses
        if (!empty($toRemove)) {
            CourseRegistration::where('student_id', $studentId)
                ->where('academic_session_id', $sessionId)
                ->whereIn('course_id', $toRemove)
                ->delete();
        }

        session()->flash('message', 'Course registration updated successfully.');
    }

    public function render()
    {
        $student = Auth::user()->student;
        $studentLevel = $student ? $student->level : 0;

        $courses = Course::where('level', '<=', $studentLevel)->orderBy('code')->get();
        return view('livewire.student.course-registration.index', [
            'courses' => $courses
        ])->layout('layouts.app');
    }
}
