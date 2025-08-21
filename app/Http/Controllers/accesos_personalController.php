<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Accesos; // <-- Modelo plural
use App\Models\vuelo;

class accesos_personalController extends Controller
{
    // Listar accesos de un control en JSON (para el modal y para la fila de detalles)
    // GET /admin/controlaeronave/{control}/accesos
    // Lista en JSON para el modal y para la fila de detalles
    public function index($controlId)
    {
        $rows = Accesos::where('vuelo_id', $controlId)
            ->orderByDesc('id')
            ->get([
                'id',
                'nombre',
                'identificacion',
                'hora_entrada','hora_salida',
                'hora_entrada1','hora_salida2',
                'herramientas','empresa',
                'motivo_entrada',
                'firma_path',
            ])
            ->map(function($r){
                // Adaptamos nombres a los que usa tu JS/vista
                $fmt = function ($v) {
                    if (!$v) return null;
                    if (is_string($v)) {
                        // 'YYYY-MM-DD HH:MM:SS' -> 'HH:MM'
                        if (strlen($v) >= 16 && strpos($v, ' ') !== false) return substr($v, 11, 5);
                        // 'HH:MM:SS' -> 'HH:MM'
                        return substr($v, 0, 5);
                    }
                    return $v;
                };
                return [
                    'id'            => $r->identificacion,
                    'nombre'        => $r->nombre,
                    'hora_entrada'  => $fmt($r->hora_entrada),
                    'hora_salida'   => $fmt($r->hora_salida),
                    'hora_entrada1' => $fmt($r->hora_entrada1),
                    'hora_salida2'  => $fmt($r->hora_salida1),
                    'herramientas'  => $r->herramientas,
                    'empresa'       => $r->empresa,
                    'motivo'        => $r->motivo_entrada,
                    'firma'         => $r->firma_path,
                ];
            });

        return response()->json($rows);
    }

    // POST /admin/controlaeronave/accesos
    public function store(Request $request)
    {
        $data = $request->validate([
            'control_id'    => 'required|exists:vuelos,id',   // id del vuelo
            'nombre'        => 'required|string|max:120',
            'id'            => 'nullable|string|max:50',      // identificacion
            'empresa'       => 'nullable|string|max:120',
            'herramientas'  => 'nullable|string|max:120',
            'motivo'        => 'nullable|string|max:200',

            'hora_entrada'  => 'nullable|date_format:H:i',
            'hora_salida'   => 'nullable|date_format:H:i',
            'hora_entrada1' => 'nullable|date_format:H:i',
            'hora_salida2'  => 'nullable|date_format:H:i',

            'firma'         => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:4096',
        ]);

        $payload = [
            'vuelo_id'       => (int) $data['control_id'],
            'nombre'         => $data['nombre'],
            'identificacion' => $data['id'] ?? null,
            'empresa'        => $data['empresa'] ?? null,
            'herramientas'   => $data['herramientas'] ?? null,
            'motivo_entrada' => $data['motivo'] ?? null,
            'hora_entrada'   => $data['hora_entrada'] ?? null,
            'hora_salida'    => $data['hora_salida'] ?? null,
            'hora_entrada1'  => $data['hora_entrada1'] ?? null,
            'hora_salida2'   => $data['hora_salida1'] ?? null,
        ];

        if ($request->hasFile('firma')) {
            $payload['firma_path'] = $request->file('firma')->store('firmas', 'public');
        }

        $row = Accesos::create($payload);

        return response()->json(['ok' => true, 'row_id' => $row->id]);
    }

    // DELETE /admin/controlaeronave/accesos/{acceso}
    public function destroy(Accesos $acceso)
    {
        if ($acceso->firma_path && Storage::disk('public')->exists($acceso->firma_path)) {
            Storage::disk('public')->delete($acceso->firma_path);
        }
        $acceso->delete();
        return response()->json(['ok' => true]);
    }

}