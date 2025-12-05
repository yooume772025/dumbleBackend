<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacation extends Model
{
    use HasFactory;

    protected $table = 'transacation';

    protected $fillable = [
        'id',
        'user_id',
        'subscription_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'currency',
        'description',
        'duration',
        'start_date',
        'end_date',
        'is_current',
        'created_at',
        'updated_at',
    ];
}
