<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'about_master';

    protected $fillable = ['id', 'user_id', 'name', 'description', 'created_at', 'updated_at'];
}
