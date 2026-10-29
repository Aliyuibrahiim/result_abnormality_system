<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'title', 'unit_load', 'level', 'coordinator_id'];

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
