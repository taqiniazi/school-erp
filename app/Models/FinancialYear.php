<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current',
    ];
}
