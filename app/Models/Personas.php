<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','identificacion','empresa','rol'];

    
// opcional
    public function vuelosCoordinados() { return $this->hasMany(vuelo::class, 'coordinador_id'); }
    public function vuelosComoLider()   { return $this->hasMany(vuelo::class, 'lider_vuelo_id'); }
}