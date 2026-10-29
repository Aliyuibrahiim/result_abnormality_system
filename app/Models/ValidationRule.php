<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ValidationRule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rule_type', 'condition', 'applicable_scope'];

    protected $casts = [
        'condition' => 'array',
    ];
}
