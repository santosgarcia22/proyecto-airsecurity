<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion;

class UbicacionFrontendController extends Controller
{
public function mapa()
    {
        $ubicaciones = Ubicacion::latest()->take(100)->get();
        return view('ubicacionesapp.mapa', compact('ubicaciones'));
    }
}
