<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;
use App\Traits\BelongsToSchool;

class Section extends Model
{
    use HasFactory, RecordsActivity, BelongsToSchool;
    
    protected $fillable = ['name', 'school_class_id'];
    
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
