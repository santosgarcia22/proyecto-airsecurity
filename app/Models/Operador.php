<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    use HasFactory;

    protected $table = 'operadores';
    protected $fillable = ['codigo','nombre'];

    public function vuelos()
    {
        return $this->hasMany(Vuelo::class, 'operador_id');
    }

}
