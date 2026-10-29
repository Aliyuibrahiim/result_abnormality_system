<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'course_id', 'ca_score', 'exam_score', 
        'total_score', 'grade', 'semester', 'academic_session_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function flaggedResults()
    {
        return $this->hasMany(FlaggedResult::class);
    }
}
