<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $table = 'work_out';

    protected $fillable = ['id', 'user_id', 'name', 'created_at', 'updated_at'];
}
