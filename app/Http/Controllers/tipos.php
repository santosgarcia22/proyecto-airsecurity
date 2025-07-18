<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tipo;

class tipos extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $tipo = tipo::select(
           "tipos.id_tipo",
           "tipos.nombre_tipo"
        )->get();
        
       return view('/tipo/show');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('/tipo/create');
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
        //
         return view('/tipo/update', ['tipo' => $tipo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

          $data = $request->validate([
            'nombre_tipo' => 'required'
        ]);
        $vuelo->nombre_tipo = $data['nombre_tipo'];
        $vuelo->updated_at = now();
        $vuelo->save();
        return redirect()->route('admin.tipo.show');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

         $registro = vuelo::where('id_tipo', $id)->first();

        if ($registro) {
            $registro->delete();
            return redirect()->route('admin.tipo.show')->with('mensaje', 'Registro eliminado exitosamente');
        }

        return redirect()->route('admin.vuelo.show')->with('mensaje', 'No se encontró el registro');
    }
}
