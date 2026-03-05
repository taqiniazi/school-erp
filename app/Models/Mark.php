<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;

class Mark extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = [
        'student_id',
        'exam_schedule_id',
        'marks_obtained',
        'remarks',
        'user_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function examSchedule()
    {
        return $this->belongsTo(ExamSchedule::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
