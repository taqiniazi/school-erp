<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'registration_number',
        'model',
        'capacity',
        'driver_id',
        'transport_route_id',
        'status',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function route()
    {
        return $this->belongsTo(TransportRoute::class, 'transport_route_id');
    }
}
