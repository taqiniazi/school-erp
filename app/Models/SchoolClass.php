<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use BelongsToSchool, HasFactory, RecordsActivity;

    protected $fillable = ['name', 'numeric_value'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'school_class_subject');
    }
}
