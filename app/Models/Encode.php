<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encode extends Model
{
    protected $fillable = [
        'id',
        'job',
        'stockCode',
        'stockDescription',
        'line',
        'targetInPcs',
        'date'
    ];

    protected $casts = [
        'id' => 'string',
    ];

}
