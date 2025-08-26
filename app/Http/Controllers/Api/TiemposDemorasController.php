<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\vuelo;
use App\Models\TiemposOperativos;
use App\Models\demoras;


class TiemposDemorasController extends Controller
{
    //

    // POST /api/v1/vuelos/{vuelo}/tiempos-demoras
    public function store(Request $request, vuelo $vuelo)
    {
        $data = $request->validate([
            // tiempos (todos opcionales)
            'tiempos.desabordaje_inicio'       => 'nullable|date_format:H:i',
            'tiempos.desabordaje_fin'          => 'nullable|date_format:H:i',
            'tiempos.inspeccion_cabina_inicio' => 'nullable|date_format:H:i',
            'tiempos.inspeccion_cabina_fin'    => 'nullable|date_format:H:i',
            'tiempos.aseo_ingreso'             => 'nullable|date_format:H:i',
            'tiempos.aseo_salida'              => 'nullable|date_format:H:i',
            'tiempos.tripulacion_ingreso'      => 'nullable|date_format:H:i',
            'tiempos.abordaje_inicio'          => 'nullable|date_format:H:i',
            'tiempos.abordaje_fin'             => 'nullable|date_format:H:i',
            'tiempos.cierre_puerta'            => 'nullable|date_format:H:i',

            // demora (opcional; una por request)
            'demora.motivo'    => 'nullable|string|max:200',
            'demora.minutos'   => 'nullable|integer|min:0',
            'demora.agente_id' => 'nullable|integer',
        ]);

        DB::transaction(function() use ($request, $vuelo) {
            $t = $request->input('tiempos', []);
            if (!empty(array_filter($t, fn($v) => $v !== null && $v !== ''))) {
                TiemposOperativos::updateOrCreate(
                    ['vuelo_id' => $vuelo->id],
                    [
                        'desabordaje_inicio'       => $t['desabordaje_inicio']       ?? null,
                        'desabordaje_fin'          => $t['desabordaje_fin']          ?? null,
                        'inspeccion_cabina_inicio' => $t['inspeccion_cabina_inicio'] ?? null,
                        'inspeccion_cabina_fin'    => $t['inspeccion_cabina_fin']    ?? null,
                        'aseo_ingreso'             => $t['aseo_ingreso']             ?? null,
                        'aseo_salida'              => $t['aseo_salida']              ?? null,
                        'tripulacion_ingreso'      => $t['tripulacion_ingreso']      ?? null,
                        'abordaje_inicio'          => $t['abordaje_inicio']          ?? null,
                        'abordaje_fin'             => $t['abordaje_fin']             ?? null,
                        'cierre_puerta'            => $t['cierre_puerta']            ?? null,
                    ]
                );
            }

            $d = $request->input('demora', []);
            if (!empty($d['motivo']) || ($d['minutos'] ?? null) !== null) {
                demoras::create([
                    'vuelo_id'  => $vuelo->id,
                    'motivo'    => $d['motivo']    ?? null,
                    'minutos'   => (int)($d['minutos'] ?? 0),
                    'agente_id' => $d['agente_id'] ?? null,
                ]);
            }
        });

        return response()->json(['ok' => true]);
    }



}