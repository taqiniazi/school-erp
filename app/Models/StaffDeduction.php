<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffDeduction extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'teacher_id',
        'name',
        'is_percentage',
        'amount',
        'is_active',
    ];

    protected $casts = [
        'is_percentage' => 'boolean',
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
