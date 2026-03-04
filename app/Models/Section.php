<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'school_class_id'];
    
    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
