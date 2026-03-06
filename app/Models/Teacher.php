<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;
use App\Traits\BelongsToSchool;

class Teacher extends Model
{
    use HasFactory, RecordsActivity, BelongsToSchool;
    
    protected $fillable = [
        'user_id',
        'salary_structure_id',
        'qualification',
        'joining_date',
        'address',
        'phone',
        'emergency_contact',
        'photo_path',
        'status'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
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
