<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vuelo;
use App\Models\Accesos;
use Illuminate\Support\Facades\Storage;


class AccesosAppController extends Controller
{
    //


     // GET /api/v1/vuelos/{vuelo}/accesos
    public function index(vuelo $vuelo)
    {
        $rows = $vuelo->accesos()
            ->orderByDesc('id')
            ->get([
                'id','nombre','identificacion','hora_entrada','hora_salida',
                'hora_entrada1','hora_salida1','herramientas','empresa',
                'motivo_entrada','firma_path'
            ]);

        return response()->json(['ok' => true, 'data' => $rows]);
    }

    // POST /api/v1/vuelos/{vuelo}/accesos
    public function store(Request $request, vuelo $vuelo)
    {
        $data = $request->validate([
            'nombre'        => 'required|string|max:120',
            'id'            => 'nullable|string|max:50',      // identificacion
            'empresa'       => 'nullable|string|max:120',
            'herramientas'  => 'nullable|string|max:120',
            'motivo'        => 'nullable|string|max:200',
            'hora_entrada'  => 'nullable|date_format:H:i',
            'hora_salida'   => 'nullable|date_format:H:i',
            'hora_entrada1' => 'nullable|date_format:H:i',
            'hora_salida1'  => 'nullable|date_format:H:i',
            'firma'         => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:4096',
        ]);

        $payload = [
            'vuelo_id'       => $vuelo->id,
            'nombre'         => $data['nombre'],
            'identificacion' => $data['id'] ?? null,
            'empresa'        => $data['empresa'] ?? null,
            'herramientas'   => $data['herramientas'] ?? null,
            'motivo_entrada' => $data['motivo'] ?? null,
            'hora_entrada'   => $data['hora_entrada'] ?? null,
            'hora_salida'    => $data['hora_salida'] ?? null,
            'hora_entrada1'  => $data['hora_entrada1'] ?? null,
            'hora_salida1'   => $data['hora_salida1'] ?? null,
        ];

        if ($request->hasFile('firma')) {
            $payload['firma_path'] = $request->file('firma')->store('firmas', 'public');
        }

        $row = Accesos::create($payload);

        return response()->json(['ok' => true, 'id' => $row->id]);
    }
}