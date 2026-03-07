<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'price',
        'billing_cycle',
        'max_students',
        'max_teachers',
        'max_campuses',
        'storage_limit_mb',
        'allowed_modules',
        'features',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'allowed_modules' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'max_students' => 'integer',
        'max_teachers' => 'integer',
        'max_campuses' => 'integer',
        'storage_limit_mb' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
