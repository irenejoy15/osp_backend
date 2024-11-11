<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActualTarget extends Model
{
    protected $fillable = [
        'id',
        'encodeId',
        'lineActual',
        'targetActual',
        'dateActual',
        'timeDropDown'
    ];

    protected $casts = [
        'id' => 'string',
        'encodeId'=>'string'
    ];

    public function Encode(){
        return $this->belongsTo(Encode::class,'encodeId','id');
    }
}
