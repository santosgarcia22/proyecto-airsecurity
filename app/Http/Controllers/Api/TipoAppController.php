<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tipo;


class TipoAppController extends Controller
{
    //

    public function index()
    {
        //retorna todos los tipos como json 

        return response()->json(tipo::all());
    }


}
