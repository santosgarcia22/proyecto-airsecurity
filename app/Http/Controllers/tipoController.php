<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tipo;
use App\Models\acceso;
use Carbon\Carbon;

class tipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $busqueda = $request->input('busqueda');

    // Empieza el query pero sin ejecutarlo
    $query = tipo::select("tipos.id_tipo", "tipos.nombre_tipo");

    if (!empty($busqueda)) {
        $query->where("tipos.nombre_tipo", "LIKE", "%$busqueda%");
    }

    // Ejecuta el query ya filtrado
    $tipos = $query->get();

    return view('tipos.show')->with(['tipo' => $tipos]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
        return view('tipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
          //validar campos

        $data = request()->validate([
            'nombre_tipo'=>'required'
        ]);

        tipo::create($data);
        
        //REDIRECCIONAR A LA VISTA SHOW

        return redirect()->route('admin.tipo.show');
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
    public function edit(tipo $tipo)
    {
        //Verificar si el tipo esta usando en la tabla acceso
        $relacionado = \App\Models\acceso::where('tipo', $tipo->id_tipo)->exists();

         return view('/tipos/update', ['tipo' => $tipo, 'relacionado'=> $relacionado]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

         $tipo = tipo::findOrFail($id);

         $relacionado = \App\Models\acceso::where('tipo', $tipo->id_tipo)->exists();

        if ($relacionado){
            //no actualizar el nombre si ya esta relacioando 
            
            return redirect()->route('admin.tipo.show')->with('error','No puedes editar el nombre, ya esta relacionado a un acceos');
        }

          $data = $request->validate([
            'nombre_tipo' => 'required'
        ]);
        $tipo->nombre_tipo = $data['nombre_tipo'];
        $tipo->updated_at = now();
        $tipo->save();
        return redirect()->route('admin.tipo.show');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

         tipo::destroy($id);
            return response()->json(['res' => true]);
        
    }
}