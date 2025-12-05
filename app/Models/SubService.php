<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    use HasFactory;

    protected $table = 'sub_service';

    protected $fillable = ['id', 'service_id', 'sub_service_name', 'logo', 'created_at', 'updated_at'];
}
