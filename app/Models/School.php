<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'campus_count',
        'address',
        'phone',
        'email',
        'tax_id',
        'website',
        'logo_path',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function admin()
    {
        return $this->hasOne(User::class)
            ->where(function ($q) {
                $q->where('role', 'school_admin')
                    ->orWhereHas('roles', function ($rq) {
                        $rq->where('name', 'School Admin');
                    });
            })
            ->latest('id');
    }

    public function campuses()
    {
        return $this->hasMany(Campus::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function getStaffCountAttribute()
    {
        // For now, let's assume staff are users with 'Teacher' or 'Admin' roles.
        // Or simply count teachers + other staff roles.
        // Since we have a Teacher model, we can count teachers.
        // Also users who are not students or parents.
        // Let's rely on the 'users' relationship and filter by role if possible,
        // or just return teacher count as a proxy if roles are complex.
        // Better: count users who have roles other than 'Student' and 'Parent'.
        // But role checks might be heavy.
        // Let's return teacher count for now as a baseline for 'Staff'.
        return $this->teachers()->count();
    }

    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function currentSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latest();
    }

    public function getCurrentPlanAttribute()
    {
        return $this->currentSubscription?->plan;
    }

    public function canAddStudent()
    {
        $plan = $this->current_plan;
        if (! $plan) {
            return false;
        }
        if (is_null($plan->max_students)) {
            return true;
        } // Unlimited

        return $this->students()->count() < $plan->max_students;
    }

    public function canAddTeacher()
    {
        $plan = $this->current_plan;
        if (! $plan) {
            return false;
        }
        if (is_null($plan->max_teachers)) {
            return true;
        }

        return $this->teachers()->count() < $plan->max_teachers;
    }

    public function canAddCampus()
    {
        $plan = $this->current_plan;
        if (! $plan) {
            return false;
        }
        if (is_null($plan->max_campuses)) {
            return true;
        }

        return $this->campuses()->count() < $plan->max_campuses;
    }
}
