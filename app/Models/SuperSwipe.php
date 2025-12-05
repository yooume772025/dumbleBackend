<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperSwipe extends Model
{
    use HasFactory;

    protected $table = 'super_swipes';

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
