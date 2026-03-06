<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class SalaryStructure extends Model
{
    use HasFactory, BelongsToSchool;
    
    protected $fillable = ['grade', 'basic_salary', 'description'];
    
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
