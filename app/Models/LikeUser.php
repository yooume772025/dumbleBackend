<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeUser extends Model
{
    use HasFactory;

    protected $table = 'like_user';

    protected $fillable = ['id', 'user_id', 'pre_user_id', 'status', 'created_at', 'updated_at'];
}
