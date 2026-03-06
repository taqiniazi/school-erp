<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class TeacherAttendance extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'teacher_id',
        'user_id',
        'date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
