<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'id',
        'name',
        'product_type',
        'price',
        'duration',
        'prodict_id',
        'description',
        'created_at',
        'updated_at',
    ];
}
