<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeRegular($query)
    {
        return $query->where('role', 'user');
    }

    protected $fillable = [
        'id',
        'name',
        'facebook_id',
        'google_id',
        'location',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'status',
        'otp',
        'dob',
        'age',
        'gender_id',
        'sub_gender_id',
        'height_id',
        'service_id',
        'about_id',
        'relation_id',
        'personal_access_tokens',
        'match_status',
        'about_me',
        'show_gender',
        'looking_for',
        'user_interests',
        'photo_url',
        'language',
        'latitude',
        'longitude',
        'education_label',
        'zodaic_sign',
        'work_out',
        'exercise',
        'pronounce',
        'device',
        'ip',
        'Institute',
        'education',
        'home_town',
        'verified',
        'current_city',
        'year',
        'intersets',
        'hide_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'looking_for' => 'array',
        'user_interests' => 'array',
    ];
}
