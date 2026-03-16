<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use BelongsToSchool, HasFactory, RecordsActivity, SoftDeletes;

    protected $fillable = [
        'school_id',
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
        'photo_path',
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

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }
}
