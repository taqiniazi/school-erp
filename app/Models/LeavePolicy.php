<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeavePolicy extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'scope',
        'year',
        'total_paid_leaves',
        'weekend_days',
        'working_days_per_month',
    ];

    protected $casts = [
        'year' => 'integer',
        'total_paid_leaves' => 'integer',
        'weekend_days' => 'array',
        'working_days_per_month' => 'integer',
    ];
}
