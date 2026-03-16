<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'grade_name',
        'min_percentage',
        'max_percentage',
        'remark',
    ];
}
