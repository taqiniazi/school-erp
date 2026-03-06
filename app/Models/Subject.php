<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;
use App\Traits\BelongsToSchool;

class Subject extends Model
{
    use HasFactory, RecordsActivity, BelongsToSchool;
    
    protected $fillable = ['name', 'code', 'type'];
    
    public function teacherAllocations()
    {
        return $this->hasMany(TeacherAllocation::class);
    }

    public function schoolClasses()
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_subject');
    }
}
