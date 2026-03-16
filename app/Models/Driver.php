<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'license_number',
        'status',
    ];
}
