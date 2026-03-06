<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;
use App\Traits\BelongsToSchool;

class Exam extends Model
{
    use HasFactory, RecordsActivity, BelongsToSchool;

    protected $fillable = [
        'name',
        'session_year',
        'description',
        'start_date',
        'end_date',
        'is_published'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean'
    ];

    public function schedules()
    {
        return $this->hasMany(ExamSchedule::class);
    }
}
