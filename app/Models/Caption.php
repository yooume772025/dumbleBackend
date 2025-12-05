<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caption extends Model
{
    use HasFactory;

    protected $table = 'caption_master';

    protected $fillable = ['id', 'user_id', 'caption_name', 'created_at', 'updated_at'];
}
