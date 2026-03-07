<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;
use App\Traits\BelongsToSchool;

class Student extends Model
{
    use HasFactory, RecordsActivity, BelongsToSchool;
    
    protected $fillable = [
        'user_id',
        'admission_number',
        'roll_number',
        'first_name',
        'last_name',
        'dob',
        'gender',
        'address',
        'phone',
        'email',
        'school_class_id',
        'section_id',
        'campus_id',
        'status',
        'admission_date',
        'photo_path'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
    
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    
    public function parents()
    {
        return $this->belongsToMany(User::class, 'student_parent', 'student_id', 'parent_id')
                    ->withPivot('relation')
                    ->withTimestamps();
    }
}
