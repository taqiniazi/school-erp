<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'is_main',
        'is_active',
        'school_id',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
