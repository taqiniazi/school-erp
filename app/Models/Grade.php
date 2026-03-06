<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class Grade extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'grade_name',
        'min_percentage',
        'max_percentage',
        'remark'
    ];
}
