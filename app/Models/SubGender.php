<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGender extends Model
{
    use HasFactory;

    protected $table = 'sub_gender';

    protected $fillable = ['id', 'gender_id', 'sub_gender_name', 'created_at', 'updated_at'];
}
