<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pression extends Model
{
    protected $fillable = [
        'valeur',
        'voltage',
    ];
}
