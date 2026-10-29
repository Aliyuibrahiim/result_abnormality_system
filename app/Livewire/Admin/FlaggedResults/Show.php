<?php

namespace App\Livewire\Admin\FlaggedResults;

use App\Models\FlaggedResult;
use App\Models\ResolutionLog;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public FlaggedResult $flaggedResult;
    public $review_notes = '';
    public $resolution_status = 'approved';
    public $new_ca_score;
    public $new_exam_score;

    public function mount(FlaggedResult $flaggedResult)
    {
        $this->flaggedResult = $flaggedResult->load('result.student', 'result.course');
        $this->new_ca_score = $this->flaggedResult->result->ca_score;
        $this->new_exam_score = $this->flaggedResult->result->exam_score;
    }

    public function logResolution()
    {
        $rules = [
            'review_notes' => 'required|string|min:5',
            'resolution_status' => 'required|in:approved,rejected,investigating,correct_score',
        ];

        if ($this->resolution_status === 'correct_score') {
            $rules['new_ca_score'] = 'required|numeric|min:0|max:30';
            $rules['new_exam_score'] = 'required|numeric|min:0|max:70';
        }

        $this->validate($rules);

        $notes = $this->review_notes;

        if ($this->resolution_status === 'correct_score') {
            $result = $this->flaggedResult->result;
            
            $oldCa = $result->ca_score;
            $oldExam = $result->exam_score;

            // Recalculate
            $total = $this->new_ca_score + $this->new_exam_score;
            $grade = 'F'; $points = 0;
            if ($total >= 70) { $grade = 'A'; $points = 5; }
            elseif ($total >= 60) { $grade = 'B'; $points = 4; }
            elseif ($total >= 50) { $grade = 'C'; $points = 3; }
            elseif ($total >= 45) { $grade = 'D'; $points = 2; }

            $result->update([
                'ca_score' => $this->new_ca_score,
                'exam_score' => $this->new_exam_score,
                'total_score' => $total,
                'grade' => $grade,
                'points' => $points,
            ]);

            $notes = "Scores Corrected (CA: $oldCa -> {$this->new_ca_score}, Exam: $oldExam -> {$this->new_exam_score}). Reason: " . $notes;
        }

        ResolutionLog::create([
            'flagged_result_id' => $this->flaggedResult->id,
            'review_notes' => $notes,
            'resolution_status' => $this->resolution_status,
            'reviewer_id' => Auth::id(),
        ]);

        if (in_array($this->resolution_status, ['approved', 'rejected', 'correct_score'])) {
            $this->flaggedResult->update(['is_resolved' => true]);
        }

        session()->flash('message', 'Resolution logged successfully.');
        return $this->redirectRoute('admin.abnormalities.show', $this->flaggedResult->id, navigate: true);
    }

    public function render()
    {
        $logs = ResolutionLog::where('flagged_result_id', $this->flaggedResult->id)
            ->with('reviewer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.flagged-results.show', [
            'logs' => $logs
        ])->layout('layouts.app');
    }
}
