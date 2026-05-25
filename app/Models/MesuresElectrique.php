<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MesuresElectrique extends Model {

    protected $table = 'mesures_electrique';

    protected $fillable = [
        'courant1', 'courant2', 'courant3',
        'tension1', 'tension2',
        'pression',
        'device_id', 'rssi',
        'recorded_at',
    ];

    protected $casts = [
        'courant1'    => 'float',
        'courant2'    => 'float',
        'courant3'    => 'float',
        'tension1'    => 'float',
        'tension2'    => 'float',
        'pression'    => 'float',
        'rssi'        => 'integer',
        'recorded_at' => 'datetime',
    ];
}
