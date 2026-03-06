<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class LibraryLoan extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'library_book_id',
        'user_id',
        'issued_at',
        'due_date',
        'returned_at',
        'per_day_fine',
        'fine_amount',
        'status',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'due_date' => 'date',
        'returned_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(LibraryBook::class, 'library_book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentOverdueDays(): int
    {
        if ($this->status !== 'issued') {
            return 0;
        }
        $today = Carbon::today();
        if ($today->gt($this->due_date)) {
            return $today->diffInDays($this->due_date);
        }
        return 0;
    }

    public function currentAccruedFine(): float
    {
        return $this->currentOverdueDays() * (float)$this->per_day_fine;
    }
}

