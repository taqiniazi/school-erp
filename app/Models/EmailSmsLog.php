<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSmsLog extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = [
        'channel',
        'recipient_group',
        'recipients',
        'subject',
        'message',
        'status',
        'error_message',
        'sent_at',
        'created_by',
    ];

    protected $casts = [
        'recipients' => 'array',
        'sent_at' => 'datetime',
    ];
}
