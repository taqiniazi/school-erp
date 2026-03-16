<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReview extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'teacher_id',
        'review_date',
        'score',
        'remarks',
        'reviewer_id',
    ];

    protected $casts = [
        'review_date' => 'date',
        'score' => 'decimal:2',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
