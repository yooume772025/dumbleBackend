<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    protected $table = 'gender_master';

    protected $fillable = ['id', 'user_id', 'gender_name', 'created_at', 'updated_at'];
}
