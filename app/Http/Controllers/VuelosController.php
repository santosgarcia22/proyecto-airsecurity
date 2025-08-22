<?php

namespace App\Http\Controllers;

use App\Models\Vuelo;
use App\Models\Operador;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VuelosController extends Controller
{
    //
public function __construct()
    {
        $this->middleware('auth'); // si usas auth
    }

 public function index(Request $request)
    {
        $q = $request->input('q');
        $fi = $request->input('fecha_inicio');
        $ff = $request->input('fecha_fin');

        $vuelos = Vuelo::with(['operador'])
            ->when($fi, fn($q2)=>$q2->whereDate('fecha', '>=', $fi))
            ->when($ff, fn($q2)=>$q2->whereDate('fecha', '<=', $ff))
            ->when($q, function($query) use ($q) {
                $query->where(function($s) use ($q){
                    $s->where('numero_vuelo_llegando', 'like', "%$q%")
                      ->orWhere('numero_vuelo_saliendo', 'like', "%$q%")
                      ->orWhere('origen', 'like', "%$q%")
                      ->orWhere('destino', 'like', "%$q%")
                      ->orWhere('matricula', 'like', "%$q%");
                });
            })
            ->orderByDesc('fecha')
            ->paginate(15)
            ->appends($request->query());

        return view('vuelos.index', compact('vuelos'));
    }



     public function create()
    {
        $operadores  = Operador::orderBy('nombre')->get();
        // $coordinadores = Persona::where('rol','COORDINADOR')->orderBy('nombre')->get();
        // $lideres       = Persona::where('rol','LIDER_VUELO')->orderBy('nombre')->get();

        return view('vuelos.create', compact('operadores'));
       // return view('vuelos.create', compact('operadores','coordinadores','lideres'));
    }




    public function store(Request $request)
    {
        $data = $request->validate([
            'fecha' => ['required','date'],
            'origen' => ['required','string','max:10'],
            'destino'=> ['required','string','max:10'],
            'numero_vuelo_llegando' => ['nullable','string','max:20'],
            'numero_vuelo_saliendo' => ['nullable','string','max:20'],
            'matricula' => ['nullable','string','max:20'],
            'operador_id' => ['required', Rule::exists('operadores','id')],
            'posicion_llegada' => ['nullable','string','max:20'],
            'hora_llegada_real' => ['nullable','date'],
            'hora_salida_itinerario' => ['nullable','date'],
            'hora_salida_pushback'   => ['nullable','date'],
            'total_pax' => ['nullable','integer','min:0'],
            // 'coordinador_id' => ['nullable', Rule::exists('personas','id')],
            // 'lider_vuelo_id' => ['nullable', Rule::exists('personas','id')],
        ]);

        $vuelo = Vuelo::create($data);

       return redirect()->route('admin.vuelo.index')->with('success','Vuelo creado.');

    }

    public function show(Vuelo $vuelo)
    {
        $vuelo->load(['operador','tiempos','demoras','accesos']);
        //$vuelo->load(['operador','coordinador','liderVuelo','tiempos','demoras','accesos']);
        return view('vuelos.show', compact('vuelo'));
    }

    public function edit(Vuelo $vuelo)
    {
        $operadores  = Operador::orderBy('nombre')->get();
      

        return view('vuelos.edit', compact('vuelo','operadores'));
    }

    public function update(Request $request, Vuelo $vuelo)
    {
        $data = $request->validate([
            'fecha' => ['required','date'],
            'origen' => ['required','string','max:10'],
            'destino'=> ['required','string','max:10'],
            'numero_vuelo_llegando' => ['nullable','string','max:20'],
            'numero_vuelo_saliendo' => ['nullable','string','max:20'],
            'matricula' => ['nullable','string','max:20'],
            'operador_id' => ['required', Rule::exists('operadores','id')],
            'posicion_llegada' => ['nullable','string','max:20'],
            'hora_llegada_real' => ['nullable','date'],
            'hora_salida_itinerario' => ['nullable','date'],
            'hora_salida_pushback'   => ['nullable','date'],
            'total_pax' => ['nullable','integer','min:0'],
            // 'coordinador_id' => ['nullable', Rule::exists('personas','id')],
            // 'lider_vuelo_id' => ['nullable', Rule::exists('personas','id')],
        ]);

        $vuelo->update($data);

        return redirect()->route('admin.vuelo.show', $vuelo)->with('success','Vuelo actualizado.');
    }

    public function destroy(Vuelo $vuelo)
    {
        $vuelo->delete();
        return redirect()->route('admin.vuelo.index')->with('success','Vuelo eliminado.');
    }


}