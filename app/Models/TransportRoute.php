<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class TransportRoute extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'name',
        'start_point',
        'end_point',
        'fare',
        'status',
    ];
}

