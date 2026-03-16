<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryStructure extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = ['grade', 'basic_salary', 'description'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
