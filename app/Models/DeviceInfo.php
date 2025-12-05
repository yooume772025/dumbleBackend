<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceInfo extends Model
{
    use HasFactory;

    protected $table = 'device_infos';

    protected $fillable = [
        'phone_name',
        'phone_no',
        'phone_address',
        'ip_address',
    ];
}
