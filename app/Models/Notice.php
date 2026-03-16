<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use BelongsToSchool, HasFactory, RecordsActivity;

    protected $fillable = [
        'title',
        'content',
        'type',
        'audience_role',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
