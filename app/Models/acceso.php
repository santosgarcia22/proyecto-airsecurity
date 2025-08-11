<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class acceso extends Model
{
    use HasFactory;

    protected $table = 'acceso'; //tabla
    protected $primaryKey = 'numero_id'; // llave primaria
    protected $fillable = ['nombre','tipo',
     'posicion', 'ingreso', 'salida', 'Sicronizacion',
      'id', 'objetos', 'vuelo']; //datos para asigancion de forma masiva
    
    // app/Models/Acceso.php

//    public function tipo()
//     {
//         return $this->belongsTo(\App\Models\tipo::class, 'tipo', 'id_tipo');
//     }
    

      public function tipoRelacion()
    {
        return $this->belongsTo(\App\Models\tipo::class, 'tipo' , 'id_tipo');
    }

     public function vueloRelacion()
    {
        return $this->belongsTo(\App\Models\vuelo::class, 'vuelo', 'id_vuelo');
    }
    
    // public function vuelo()
    // {
    //     return $this->belongsTo(\App\Models\vuelo::class, 'vuelo', 'id_vuelo');
    // }


}