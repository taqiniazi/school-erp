<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    
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
    
    public function parents()
    {
        return $this->belongsToMany(User::class, 'student_parent', 'student_id', 'parent_id')
                    ->withPivot('relation')
                    ->withTimestamps();
    }
}
