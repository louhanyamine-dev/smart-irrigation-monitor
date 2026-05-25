<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MesuresPression extends Model
{
    protected $table = 'mesures_pression';

    protected $fillable = [
        'pression1',
        'pression2',
        'voltage1',
        'voltage2',
        'device_id',
        'recorded_at',
    ];

    protected $casts = [
        'pression1'   => 'float',
        'pression2'   => 'float',
        'voltage1'    => 'float',
        'voltage2'    => 'float',
        'recorded_at' => 'datetime',
    ];
}
