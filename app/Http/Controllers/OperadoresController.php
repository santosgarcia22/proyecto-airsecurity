<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use Illuminate\Http\Request;

class OperadoresController extends Controller
{
    //

    public function index()
        {
            $operadores = Operador::orderBy('nombre')->get();
            return response()->json($operadores); // para cargar en el modal con AJAX si quieres
        }
    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:10|unique:operadores,codigo',
            'nombre' => 'required|string|max:100',
        ]);

        $operador = Operador::create($data);

        if ($request->ajax()) {
            return response()->json($operador);
        }

        return redirect()->back()->with('success', 'Operador agregado.');
    }

    public function destroy(string $id)
    {
        $deleted = Operador::destroy($id);

        if ($deleted) {
            return response()->json(['ok' => true]);
        }

        return response()->json(['ok' => false], 400);
    }



}