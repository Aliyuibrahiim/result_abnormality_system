<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResolutionLog extends Model
{
    use HasFactory;

    protected $fillable = ['flagged_result_id', 'review_notes', 'resolution_status', 'reviewer_id'];

    public function flaggedResult()
    {
        return $this->belongsTo(FlaggedResult::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
