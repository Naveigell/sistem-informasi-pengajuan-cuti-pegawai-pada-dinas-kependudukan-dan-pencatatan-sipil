<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    const ROLE_ADMIN              = 'admin';
    const ROLE_HEAD_OF_FIELD      = 'head_of_field';
    const ROLE_HEAD_OF_DEPARTMENT = 'head_of_department';
    const ROLE_EMPLOYEE            = 'employee';

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
    ];

    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeEmployee($query)
    {
        return $query->where('role', User::ROLE_EMPLOYEE);
    }

    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function isLeader()
    {
        return in_array($this->role, [self::ROLE_HEAD_OF_FIELD, self::ROLE_HEAD_OF_DEPARTMENT]);
    }
}
