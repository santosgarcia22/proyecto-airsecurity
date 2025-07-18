<?php

namespace App\Http\Controllers\Controles;

use App\Http\Controllers\Controller;
use App\Models\P_Departamento;
use App\Models\P_UsuarioDepartamento;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use App\Models\acceso;
use App\Models\vuelo;
use App\Models\tipo;


class ControlController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexRedireccionamiento(){

        $user = Auth::user();

        // ADMINISTRADOR SISTEMA
        if($user->hasRole('admin')){
            $ruta = 'admin.home';
        }
        else if($user->hasRole('usuario')){
            $ruta = 'admin.dashboard.index';
        }
        else{
            // no tiene ningun permiso de vista, redirigir a pantalla sin permisos
            $ruta = 'no.permisos.index';
        }

        $titulo = "Proyecto ASG";

        return view('backend.index', compact( 'ruta', 'user', 'titulo'));
    }

  public function home()
{
    $user = Auth::user();
    if ($user->hasRole('admin')) {
        $ruta = 'admin.roles.index';
    } elseif ($user->hasRole('usuario')) {
        $ruta = 'admin.dashboard.index';
    } else {
        $ruta = 'no.permisos.index';
    }

    // === GRAFICA ACCESOS POR VUELO ===
      // Accesos por Vuelo (para gráfica lineal)
    $accesos = \App\Models\Acceso::select('vuelo', \DB::raw('count(*) as total'))
        ->whereNotNull('vuelo')
        ->groupBy('vuelo')
        ->get();

    $labelsVuelos = [];
    $dataVuelos = [];
    foreach ($accesos as $acceso) {
        $vuelo = \App\Models\Vuelo::find($acceso->vuelo);
        $labelsVuelos[] = $vuelo ? $vuelo->numero_vuelo : 'Desconocido';
        $dataVuelos[] = $acceso->total;
    }

    // Accesos por Hora (hoy)
    $accesosPorHora = [];
    $labelsHoras = [];
    $hoy = Carbon::today();
    for ($h = 0; $h < 24; $h++) {
        $labelsHoras[] = sprintf('%02d:00', $h);
        $accesosPorHora[$h] = 0;
    }
    $accesosHoy = \App\Models\Acceso::whereDate('ingreso', $hoy)->get();
    foreach ($accesosHoy as $acceso) {
        $hora = Carbon::parse($acceso->ingreso)->format('G');
        $accesosPorHora[$hora]++;
    }
    $dataHoras = array_values($accesosPorHora);

    // Tarjetas y otros datos
    $totalUsuarios = \App\Models\Usuario::count();
    $accesosHoyCount = \App\Models\Acceso::whereDate('ingreso', today())->count();
    $totalVuelos = \App\Models\Vuelo::count();
    $alertas = 0;
    $accesosRecientes = \App\Models\acceso::with(['tipo', 'vuelo'])
    ->orderByDesc('numero_id')
    ->take(10)
    ->get();


//dd($accesosRecientes->toArray());

//dd($labelsVuelos, $dataVuelos, $accesosPorHora,$labelsHoras); // Solo temporal, antes del return

    return view('backend.admin.home.home', compact(
        'accesosHoyCount', 'totalUsuarios', 'totalVuelos', 'alertas', 'accesosRecientes',
        'labelsVuelos', 'dataVuelos', 'labelsHoras', 'dataHoras'
    ));
}

   
    // redirecciona a vista sin permisos
    public function indexSinPermiso(){
        return view('errors.403');
    }

}