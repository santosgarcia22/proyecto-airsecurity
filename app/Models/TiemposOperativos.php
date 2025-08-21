<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiemposOperativos extends Model
{
    use HasFactory;

    protected $table = 'tiempos_operativos';
    protected $fillable = [
        'vuelo_id','desabordaje_inicio','desabordaje_fin','inspeccion_cabina_inicio',
        'inspeccion_cabina_fin','aseo_ingreso','aseo_salida','tripulacion_ingreso',
        'salida_itinerario','abordaje_inicio','abordaje_fin','cierre_puerta'
    ];
    public $timestamps = true;



}