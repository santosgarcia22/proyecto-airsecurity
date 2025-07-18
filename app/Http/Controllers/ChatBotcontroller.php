<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatBotcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function responder(Request $request)
    {
        $mensaje = strtolower($request->mensaje);
        $respuesta = 'Lo siento, no entendí.';

        if (str_contains($mensaje, 'hola')) {
            $respuesta = '¡Hola! ¿En qué puedo ayudarte?';
        } elseif (str_contains($mensaje, 'horario')) {
            $respuesta = 'Nuestro horario es de lunes a viernes de 8 a 5.';
        } elseif (str_contains($mensaje, 'precio')) {
            $respuesta = 'Puedes consultar los precios en la sección de productos.';
        }

        return response()->json(['respuesta' => $respuesta]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
