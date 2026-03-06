<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class Driver extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'name',
        'phone',
        'license_number',
        'status',
    ];
}

