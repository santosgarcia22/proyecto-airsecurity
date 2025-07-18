<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vuelo;
use App\Models\acceso;
use Carbon\Carbon;

class VueloFrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        // verificar si hay filtro seleccionado 

        $busqueda = $request->input('busqueda');

         $vuelo = vuelo::select(
           "vuelo.id_vuelo",
           "vuelo.fecha",
           "vuelo.numero_vuelo",
           "vuelo.matricula",
           "vuelo.destino",
           "vuelo.origen"
         );


       if (!empty($busqueda)) {
        $vuelo->where(function($q) use ($busqueda) {
            $q->where("vuelo.numero_vuelo", "LIKE", "%$busqueda")
            ->orWhere("vuelo.id_vuelo", "LIKE", "%$busqueda" );
        });
    }
        
        //paginado 
        $perPage = $request->input('per_page',5);
        $vuelo = $vuelo->paginate(5);


        
       return view('/vuelo/show')->with(['vuelo' => $vuelo]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
            //    $vuelo = vuelo::all();

        return view('/vuelo/create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validar campos

        $data = request()->validate([
            'fecha'=>'required',
            'numero_vuelo'=>'required',
            'matricula'=>'required',
            'destino'=>'required',
            'origen'=>'required'
        ]);

        vuelo::create($data);
        
        //REDIRECCIONAR A LA VISTA SHOW

        return redirect()->route('admin.vuelo.show');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(vuelo $vuelo)
    {
        $relacionado = acceso::where('vuelo', $vuelo->id_vuelo)->exists();

        return view('/vuelo/update', ['vuelo' => $vuelo, 'relacionado' => $relacionado]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, vuelo $vuelo)
    {
        //
        $data = $request->validate([
            'fecha' => 'required',
            'numero_vuelo' => 'required',
            'matricula' => 'required',
            'destino' => 'required',
            'origen' => 'required'
        ]);
        $data['fecha']= Carbon::parse($data['fecha'])->format('Y-m-d H:i:s');
        $vuelo->fecha = $data['fecha'];
        $vuelo->numero_vuelo = $data['numero_vuelo'];
        $vuelo->matricula = $data['matricula'];
        $vuelo->destino = $data['destino'];
        $vuelo->origen = $data['origen'];
        $vuelo->updated_at = now();
        $vuelo->save();
        return redirect()->route('admin.vuelo.show');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
       
        vuelo::destroy($id);
        return response()->json(['res'=> true]);
    }
}