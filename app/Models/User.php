<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $dates = [
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'full_name',
        'is_email_verified',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'device_token' => 'array',
        'device_id' => 'array'
    ];

    public function getIsEmailVerifiedAttribute()
    {

        if (!empty($this->email_verified_at)) {
            return 'verified';
        }
        return 'unverified';
    }

    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
