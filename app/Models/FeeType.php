<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToSchool;

class FeeType extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = ['name', 'description'];

    public function structures()
    {
        return $this->hasMany(FeeStructure::class);
    }
}
