<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vuelo extends Model
{
    use HasFactory;

   protected $table = 'vuelos';

    protected $fillable = [
        'fecha','origen','destino',
        'numero_vuelo_llegando','numero_vuelo_saliendo',
        'matricula','operador_id','posicion_llegada',
        'hora_llegada_real','hora_salida_itinerario','hora_salida_pushback',
        'total_pax',
    ];

    // 'coordinador_id','lider_vuelo_id'
    protected $casts = [
        'fecha' => 'date',
        'hora_llegada_real'     => 'datetime',
        'hora_salida_itinerario'=> 'datetime',
        'hora_salida_pushback'  => 'datetime',
    ];

    // Relaciones
    public function operador()     { return $this->belongsTo(Operador::class, 'operador_id'); }
    // public function coordinador()  { return $this->belongsTo(Persona::class, 'coordinador_id'); }
    // public function liderVuelo()   { return $this->belongsTo(Persona::class, 'lider_vuelo_id'); }

    public function accesos()      { return $this->hasMany(Accesos::class, 'vuelo_id'); }
    public function demoras()      { return $this->hasMany(demoras::class, 'vuelo_id'); }
    public function tiempos()      { return $this->hasOne(TiemposOperativos::class, 'vuelo_id'); }
}
