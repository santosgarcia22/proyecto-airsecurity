<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\acceso;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccesosExport;

class AccesoApiController extends Controller
{
    public function index()
    {
        return response()->json(acceso::all());
    }

    public function show($id)
    {
        $acceso = acceso::find($id);
        if ($acceso) {
            return response()->json($acceso);
        } else {
            return response()->json(['message' => 'Acceso no encontrado'], 404);
        }
    }
    public function store(Request $request)
    {
        $data = $request->all();

        // Por defecto, imagen dummy
        $data['objetos'] = 'default.jpg';

        // Si viene la imagen base64, la procesamos
            if ($request->has('imagen_base64')) {
            $imagen = $request->input('imagen_base64');
            $nombreArchivo = 'img_' . time() . '.jpg';

            // Guarda la imagen en storage/app/public/objetos
            Storage::disk('public')->put('objetos/' . $nombreArchivo, base64_decode($imagen));

            // Guarda la ruta relativa para acceso público
            $data['objetos'] = 'storage/objetos/' . $nombreArchivo; // ruta para mostrar desde la web
            unset($data['imagen_base64']);
        }
        // Asignar campos fijos o dummy si faltan
        $data['tipo'] = $request->tipo ?? 1;
        $data['posicion'] = $request->posicion ?? 'N/A';
        $data['ingreso'] = $request->ingreso ?? now();
        $data['salida'] = $request->salida ?? now();
        $data['Sicronizacion'] = $request->Sicronizacion ?? now();
        $data['id'] = $request->id ?? 'testAPI';
        $data['vuelo'] = $request->vuelo ?? 1;

        // Guardar registro
        $nuevo = acceso::create($data);

        return response()->json([
            'success' => true,
            'msg' => '¡Guardado!',
            'ruta' => $data['objetos'],
            'id' => $nuevo->numero_id
        ], 201);
    }


    public function exportarExcel()
{
    return Excel::download(new AccesosExport, 'accesos.xlsx');
}



}