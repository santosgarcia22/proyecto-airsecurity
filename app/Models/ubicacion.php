<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicacion';
    protected $fillable = ['usuario_id', 'latitud', 'longitud', 'fecha_hora'];
}
