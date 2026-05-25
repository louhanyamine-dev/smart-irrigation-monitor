<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MesuresWatermark extends Model
{
    protected $table = 'mesures_watermark';

    protected $fillable = [
        'watermark1',
        'watermark2',
        'watermark3',
        'watermark4',
        'watermark5',
        'watermark6',
        'device_id',
        'recorded_at',
    ];

    protected $casts = [
        'watermark1'  => 'float',
        'watermark2'  => 'float',
        'watermark3'  => 'float',
        'watermark4'  => 'float',
        'watermark5'  => 'float',
        'watermark6'  => 'float',
        'recorded_at' => 'datetime',
    ];
}
