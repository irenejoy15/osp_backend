<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WipMaster extends Model
{
    protected $connection = 'sqlsrv1';
    protected $table='WipMaster';
}
