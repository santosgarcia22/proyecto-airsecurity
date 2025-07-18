<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo extends Model
{
    use HasFactory;

    protected $table = 'tipos'; //tabla
    protected $primaryKey = 'id_tipo'; // llave primaria
    protected $fillable = ['nombre_tipo']; //datos para asigancion de forma masiva
}
