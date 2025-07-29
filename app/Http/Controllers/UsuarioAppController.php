<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UsuarioApp;
use Illuminate\Database\QueryException;

class UsuarioAppController extends Controller
{
   public function index(Request $request)
{
    $usuarios = UsuarioApp::all();
    $busqueda = $request->input('busqueda');


    $query = UsuarioApp::query();

    if (!empty($busqueda)) {
        $query->where(function($q) use ($busqueda) {
            $q->where("usuario", "LIKE", "%$busqueda%")
              ->orWhere("nombre_completo", "LIKE", "%$busqueda%")
              ->orWhere("email", "LIKE", "%$busqueda%");
        });
    }

   $usuarios = $query->orderBy('id_usuario', 'desc')->get();


    return view('usuariosapp.index', compact('usuarios'));
}

    public function store(Request $request)
{
    try {
        // validaciones básicas
        $request->validate([
            'nombre_completo' => 'required|max:100',
            'usuario' => 'required|max:50|unique:usuarios_app,usuario',
            'email' => 'required|email|unique:usuarios_app,email',
            'password' => 'required|min:6'
        ]);

        UsuarioApp::create([
            'nombre_completo' => $request->nombre_completo,
            'usuario' => $request->usuario,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activo' => 1
        ]);

        return redirect()->back()->with('success', 'Usuario creado correctamente.');

    } catch (QueryException $e) {
        if ($e->errorInfo[1] == 1062) {
            return redirect()->back()->with('error', 'El usuario o correo ya están registrados.');
        }

        return redirect()->back()->with('error', 'Ocurrió un error al guardar el usuario.');
    }
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