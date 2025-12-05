<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAbout extends Model
{
    use HasFactory;

    protected $table = 'user_about';

    protected $fillable = ['id', 'user_id', 'about_id', 'description', 'created_at', 'updated_at'];
}
