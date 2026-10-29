<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    protected $fillable = ['student_id', 'course_id', 'academic_session_id'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }
}
