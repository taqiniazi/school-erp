<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRoute extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'name',
        'start_point',
        'end_point',
        'fare',
        'status',
    ];
}
