<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_master';

    protected $fillable = ['id', 'user_id', 'name', 'status', 'created_at', 'updated_at'];
}
