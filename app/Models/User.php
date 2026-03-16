<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\BelongsToSchool;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use BelongsToSchool, HasApiTokens, HasFactory, Notifiable, RecordsActivity, SoftDeletes;
    use HasRoles {
        hasRole as traitHasRole;
    }

    /**
     * Override hasRole to support local role column
     */
    public function hasRole($roles, ?string $guard = null): bool
    {
        // Check local role column for Super Admin
        if ($this->role === 'super_admin') {
            if (is_string($roles) && ($roles === 'Super Admin' || str_contains($roles, 'Super Admin'))) {
                return true;
            }
            if (is_array($roles) && in_array('Super Admin', $roles)) {
                return true;
            }
        }

        // Check local role column for School Admin
        if ($this->role === 'school_admin') {
            if (is_string($roles) && ($roles === 'School Admin' || str_contains($roles, 'School Admin'))) {
                return true;
            }
            if (is_array($roles) && in_array('School Admin', $roles)) {
                return true;
            }
        }

        return $this->traitHasRole($roles, $guard);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'phone_number',
        'password',
        'school_id',
        'ui_settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ui_settings' => 'array',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_parent', 'parent_id', 'student_id')
            ->withPivot('relation')
            ->withTimestamps();
    }

    public function studentProfile()
    {
        return $this->hasOne(Student::class);
    }

    public function teacherProfile()
    {
        return $this->hasOne(Teacher::class);
    }

    public function superAdminProfile()
    {
        return $this->hasOne(SuperAdmin::class);
    }
}
