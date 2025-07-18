<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsuarioApp extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios_app';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'usuario',
        'email',
        'password',
        'activo',
        'nombre_completo'
    ];

    protected $hidden = ['password'];
}
