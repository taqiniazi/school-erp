<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use BelongsToSchool, HasFactory, RecordsActivity;

    protected $fillable = ['name', 'school_class_id', 'campus_id'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
}
