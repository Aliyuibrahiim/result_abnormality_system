<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlaggedResult extends Model
{
    use HasFactory;

    protected $fillable = ['result_id', 'abnormality_type', 'severity', 'is_resolved'];

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function resolutionLogs()
    {
        return $this->hasMany(ResolutionLog::class);
    }
}
