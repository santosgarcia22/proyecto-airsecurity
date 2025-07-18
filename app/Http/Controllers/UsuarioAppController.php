<?php

namespace App\Http\Controllers;

use App\Models\UsuarioApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioAppdController extends Controller
{
   public function index(Request $request)
{
    $busqueda = $request->input('busqueda');

    $query = UsuarioApp::query();

    if (!empty($busqueda)) {
        $query->where(function($q) use ($busqueda) {
            $q->where("usuario", "LIKE", "%$busqueda%")
              ->orWhere("nombre_completo", "LIKE", "%$busqueda%")
              ->orWhere("email", "LIKE", "%$busqueda%");
        });
    }

    $usuarios = $query->orderBy('id_usuario', 'desc')->paginate(10);

    return view('usuariosapp.index', compact('usuarios'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo' => 'required',
            'usuario' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['activo'] = true;

        UsuarioApp::create($data);
        return back();
    }

    public function show(string $id)
    {
        $usuario = UsuarioApp::findOrFail($id);
        return response()->json($usuario);
    }

    public function update(Request $request, $id)
    {
        $usuario = UsuarioApp::findOrFail($id);

        $data = $request->validate([
            'nombre_completo' => 'required',
            'usuario' => 'required',
            'email' => 'required|email',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);
        return back();
    }

    public function toggleActivo($id)
    {
        $usuario = UsuarioApp::findOrFail($id);
        $usuario->activo = !$usuario->activo;
        $usuario->save();

        return response()->json(['res' => true]);
    }
}