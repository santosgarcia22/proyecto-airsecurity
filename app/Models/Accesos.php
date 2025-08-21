<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesos extends Model
{
    protected $table = 'accesos';
    protected $fillable = [
        'vuelo_id','nombre','identificacion','empresa','herramientas','motivo_entrada',
        'hora_entrada','hora_salida','hora_entrada1','hora_salida2','firma_path'
    ];
    public $timestamps = true;

    public function vuelo()
    {
        return $this->belongsTo(vuelo::class, 'vuelo_id', 'id');
    }
}

