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
        'fecha', 'origen', 'destino', 'numero_vuelo_llegando','numero_vuelo_saliendo',
        ];


     public function accesos()
    {
        return $this->hasMany(\App\Models\accesos_personal::class,'control_id','id_control_aeronave');
    }

}