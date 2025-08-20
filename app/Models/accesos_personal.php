<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accesos_personal extends Model
{
    use HasFactory;

    protected $table = 'accesos_personal';
    protected $primaryKey = 'id_personal';
    protected $fillable = [
        'control_id','nombre','id',
        'hora_entrada','hora_salida','hora_entrada1','hora_salida1',
        'herramientas','empresa','motivo','firma'
    ];

  public function control()
    {
        return $this->belongsTo(\App\Models\controlAero::class,'control_id','id_control_aeronave');
    }



}
