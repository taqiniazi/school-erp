<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class LibraryBook extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publisher',
        'copies_total',
        'copies_available',
        'shelf',
        'status',
    ];
}

