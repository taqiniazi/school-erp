<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class StudentTransport extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'student_id',
        'transport_route_id',
        'vehicle_id',
        'pickup_point',
        'start_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function route()
    {
        return $this->belongsTo(TransportRoute::class, 'transport_route_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
