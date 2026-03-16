<?php

namespace App\Traits;

use App\Models\School;
use App\Services\SchoolContext;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToSchool
{
    public static function bootBelongsToSchool()
    {
        static::addGlobalScope('school', function (Builder $builder) {
            if (SchoolContext::check()) {
                $builder->where($builder->getModel()->getTable().'.school_id', SchoolContext::getSchoolId());
            }
        });

        static::creating(function ($model) {
            if (SchoolContext::check()) {
                $model->school_id = SchoolContext::getSchoolId();
            }
        });
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
