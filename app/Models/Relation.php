<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    protected $table = 'relation_master';

    protected $fillable = ['id', 'user_id', 'name', 'logo', 'created_at', 'updated_at'];
}
