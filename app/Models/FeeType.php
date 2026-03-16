<?php

namespace App\Models;

use App\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    use BelongsToSchool, HasFactory;

    protected $fillable = ['name', 'description'];

    public function structures()
    {
        return $this->hasMany(FeeStructure::class);
    }
}
