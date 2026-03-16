<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use BelongsToSchool, HasFactory, RecordsActivity, SoftDeletes;

    protected $fillable = [
        'school_id',
        'user_id',
        'salary_structure_id',
        'qualification',
        'joining_date',
        'address',
        'phone',
        'emergency_contact',
        'campus_id',
        'photo_path',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function staffProfile()
    {
        return $this->hasOne(StaffProfile::class);
    }

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }

    public function allocations()
    {
        return $this->hasMany(TeacherAllocation::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_allocations', 'teacher_id', 'subject_id')
            ->distinct();
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'teacher_allocations', 'teacher_id', 'school_class_id')
            ->distinct();
    }
}
