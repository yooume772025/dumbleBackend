<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Height extends Model
{
    use HasFactory;

    protected $table = 'height_master';

    protected $fillable = ['id', 'user_id', 'name', 'created_at', 'updated_at'];
}
