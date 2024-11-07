<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encode extends Model
{
    protected $fillable = [
        'id',
        'job',
        'stock_code',
        'stock_description',
        'line',
        'pcs',
    ];

    protected $casts = [
        'id' => 'string',
    ];
}
