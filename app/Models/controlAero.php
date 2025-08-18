<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class controlAero extends Model
{
    use HasFactory;

    protected $table = 'control_aeronave';
    protected $primaryKey = 'id_control_aeronave';
    public $timestamps = true;


    protected $fillable = [
        'fecha','origen','numero_vuelo','hora_llegada','posicion_llegada',
        'matricula_operador','coordinador_lider',
        'desabordaje_inicio','desabordaje_fin',
        'inspeccion_cabina_inicio','inspeccion_cabina_fin',
        'aseo_ingreso','aseo_salida',
        'tripulacion_ingreso','salida_itinerario',
        'abordaje_inicio','abordaje_fin','cierre_puertas',
        'agente_nombre','agente_id','agente_firma',
        'demora_tiempo','demora_motivo',
        'destino','total_pax','hora_real_salida',
        'nombre','id','hora_entrada','hora_salida','hora_entrada1','hora_salida1', 
        'herramientas','empresa','motivo','firma'
        ];


       public function accesos()
    {
        // hasMany(ModelRelacion, foreignKey, localKey)
        return $this->hasMany(accesos_personal::class, 'control_id', 'id_control_aeronave');
    
    }
}