<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date_time' => 'datetime',
        'expires_at' => 'datetime',
    ];

    //
}
