<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsuarioApp;
use Illuminate\Support\Facades\Hash;

class UsuarioAppController extends Controller
{
     // Login
    public function login(Request $request)
    {
        \Log::info('Request recibido', $request->all());

        $request->validate([
            'usuario' => 'required',
            'password' => 'required'
        ]);
        $user = UsuarioApp::where('usuario', $request->usuario)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login OK (puedes retornar el user info o un token)
            return response()->json(['success' => true, 'user' => 
            $user]);
        } else {
            // Login FAIL
            return response()->json(['success' => false, 
            'message' => 'Credenciales incorrectas'], 200);
        }
    }

    
}
