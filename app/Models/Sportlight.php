<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sportlight extends Model
{
    use HasFactory;

    protected $table = 'sport_lights';

    protected $fillable = [
        'id',
        'name',
        'sportlights',
        'price',
        'status',
        'created_at',
        'updated_at',
    ];
}
