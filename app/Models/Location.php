<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = ['id', 'user_id', 'name', 'city', 'created_at', 'updated_at'];
}
