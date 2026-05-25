<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    protected $table = 'sensor_data';

    protected $fillable = [
        'device_id',
        'pressure',
        'voltage',
        'recorded_at',
        'watermark',
    ];

    protected $casts = [
        'pressure' => 'float',
        'voltage' => 'float',
        'recorded_at' => 'datetime',
    ];
}
