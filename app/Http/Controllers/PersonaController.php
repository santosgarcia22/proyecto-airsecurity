<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personas;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = trim($request->input('busqueda', ''));
        $q = Personas::select('id','nombre','identificacion','empresa','rol');

        if ($busqueda !== '') {
            $q->where(function ($w) use ($busqueda) {
                $w->where('nombre', 'like', "%{$busqueda}%")
                  ->orWhere('identificacion', 'like', "%{$busqueda}%")
                  ->orWhere('empresa', 'like', "%{$busqueda}%")
                  ->orWhere('rol', 'like', "%{$busqueda}%");
            });
        }

        // si quieres paginación por Laravel:
        $personas = $q->orderBy('id','desc')->paginate(10)->withQueryString();

        return view('personas.show', compact('personas','busqueda'));
    }

    public function create() { return view('personas.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'         => 'required|max:120',
            'identificacion' => 'required|max:50|unique:personas',
            'empresa'        => 'required|max:120',
            'rol'            => 'required|in:AGENTE,OFICIAL,COORDINADOR,LIDER_VUELO,OTRO',
        ]);

        Personas::create($data);
        return redirect()->route('admin.personas.index')->with('success','Persona registrada correctamente.');
    }

    public function edit(Personas $personas) { return view('personas.update', compact('personas')); }

    public function update(Request $request, Personas $personas)
    {
        $data = $request->validate([
            'nombre'         => 'required|max:120',
            'identificacion' => 'required|max:50|unique:personas,identificacion,' . $personas->id,
            'empresa'        => 'required|max:120',
            'rol'            => 'required|in:AGENTE,OFICIAL,COORDINADOR,LIDER_VUELO,OTRO',
        ]);

        $personas->update($data);
        return redirect()->route('admin.personas.index')->with('success','Persona actualizada correctamente.');
    }

    // ✅ IMPORTANTE: type-hint correcto y JSON limpio para AJAX delete
    public function destroy(Personas $persona)
    {
        $persona->delete();
        return response()->json(['ok' => true]);
    }

}