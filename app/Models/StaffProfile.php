<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    use BelongsToSchool, HasFactory, RecordsActivity;

    protected $fillable = [
        'teacher_id',
        'designation',
        'department',
        'phone',
        'address',
        'join_date',
        'status',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
