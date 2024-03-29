<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'first_name',
        'last_name',
        'occupation',
        'avatar',
        'role',
        'phone_number',
        'verified_at',
        'is_verified'
    ];

    protected $appends = ['fullname'];

    /**
     * Get the Patient's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' '. $this->last_name;
    }

    public function auth_provider()
    {
        return $this->hasOne(AuthProvider::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'referred_by_id');
    }
}
