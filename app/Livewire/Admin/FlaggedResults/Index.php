<?php

namespace App\Livewire\Admin\FlaggedResults;

use App\Models\FlaggedResult;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $status = 'pending';

    public function render()
    {
        $query = FlaggedResult::with(['result.student', 'result.course']);
        
        if ($this->status === 'pending') {
            $query->where('is_resolved', false);
        } elseif ($this->status === 'resolved') {
            $query->where('is_resolved', true);
        }

        return view('livewire.admin.flagged-results.index', [
            'flaggedResults' => $query->orderBy('created_at', 'desc')->paginate(15)
        ])->layout('layouts.app');
    }
}
