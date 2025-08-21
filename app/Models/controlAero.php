<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class controlAero extends Model
{
    protected $table = 'control_aeronave';    // pon el nombre REAL
    protected $primaryKey = 'id_control_aeronave'; // si tu PK real es éste
    public $timestamps = true;

    protected $fillable = [
        'fecha','origen','destino','numero_vuelo','hora_llegada','posicion_llegada',
        'matricula_operador','coordinador_lider',
        // tiempos
        'desabordaje_inicio','desabordaje_fin','inspeccion_cabina_inicio','inspeccion_cabina_fin',
        'aseo_ingreso','aseo_salida','tripulacion_ingreso','salida_itinerario','abordaje_inicio','abordaje_fin','cierre_puertas',
        // seguridad
        'agente_nombre','agente_id','agente_firma',
        // demoras/pax
        'demora_tiempo','demora_motivo','total_pax','hora_real_salida',
        // extras que guardas en la misma tabla (si aplica)
        'firma'
    ];

    public function accesos()
    {
        return $this->hasMany(Accesos::class, 'vuelo_id', 'id_control_aeronave');
    }


}