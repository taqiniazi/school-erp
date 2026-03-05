<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;

class SchoolClass extends Model
{
    use HasFactory, RecordsActivity;
    
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
