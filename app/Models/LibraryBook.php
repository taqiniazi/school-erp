<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    use BelongsToSchool, HasFactory;

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
