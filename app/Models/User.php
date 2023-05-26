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
        'group',
        'role',
    ];

    const ROLE_ADMIN              = 'admin';
    const ROLE_HEAD_OF_FIELD      = 'head_of_field';
    const ROLE_HEAD_OF_DEPARTMENT = 'head_of_department';
    const ROLE_EMPLOYEE           = 'employee';

    const GROUPS = [
        "I" => [
            "I-A" => "Juru Muda",
            "I-B" => "Juru Muda Tingkat 1",
            "I-C" => "Juru",
            "I-D" => "Juru Tingkat 1",
        ],
        "II" => [
            "II-A" => "Pengatur Muda",
            "II-B" => "Pengatur Muda Tingkat 1",
            "II-C" => "Pengatur",
            "II-D" => "Pengatur Tingkat 1",
        ],
        "III" => [
            "III-A" => "Penata Muda",
            "III-B" => "Penata Muda Tingkat 1",
            "III-C" => "Penata",
            "III-D" => "Penata Tingkat 1",
        ],
        "IV" => [
            "IV-A" => "Pembina Muda",
            "IV-B" => "Pembina Muda Tingkat 1",
            "IV-C" => "Pembina",
            "IV-D" => "Pembina Tingkat 1",
        ],
    ];

    const GROUP_HEADS = [
        "I" => "Juru",
        "II" => "Pengatur",
        "III" => "Penata",
        "IV" => "Pembina"
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
    ];

    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function getRoleTranslatedAttribute()
    {
        return self::getRoleTranslated()[$this->role];
    }

    public static function getRoleTranslated()
    {
        return [
            self::ROLE_ADMIN => "Admin",
            self::ROLE_HEAD_OF_FIELD => "Kepala Bidang",
            self::ROLE_HEAD_OF_DEPARTMENT => "Kepala Dinas",
            self::ROLE_EMPLOYEE => "Pegawai",
        ];
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
