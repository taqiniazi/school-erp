<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class FinancialYear extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current',
    ];
}

