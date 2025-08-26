<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demoras extends Model
{
    use HasFactory;
    
    protected $table = 'demoras';
    protected $PrimaryKey ="id";
    protected $fillable = ['vuelo_id','motivo','minutos','agente_id'];
    public $timestamps = true;
}
