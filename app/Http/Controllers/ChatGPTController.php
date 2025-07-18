<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ChatGPTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function responder(Request $request)
    {
        $mensaje = $request->mensaje;

        $apiKey = env('OPENAI_API_KEY'); // Asegúrate de tenerla en .env
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un asistente útil para usuarios de la plataforma web.'],
                ['role' => 'user', 'content' => $mensaje],
            ]
        ]);

        $respuesta = $response['choices'][0]['message']['content'] ?? 'Lo siento, hubo un error.';

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
