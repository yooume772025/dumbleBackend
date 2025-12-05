<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sociallogin extends Model
{
    use HasFactory;

    protected $table = 'social_login';

    protected $fillable = [
        'id',
        'name',
        'app_key',
        'app_secret',
        'created_at',
        'updated_at',
    ];
}
