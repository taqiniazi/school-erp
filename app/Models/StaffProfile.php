<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordsActivity;

class StaffProfile extends Model
{
    use HasFactory, RecordsActivity;

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

