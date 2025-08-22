<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use App\Models\vuelo;               // tabla: vuelos
use App\Models\Accesos;             // tabla: accesos
use App\Models\demoras;             // tabla: demoras
use App\Models\TiemposOperativos;   // tabla: tiempos_operativos
use App\Models\Operador;            // tabla: operadores

class ControlAeronaveController extends Controller
{
    /* ===========================
     *  INDEX: lista VUELOS para la vista
     * =========================== */
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);

        $q = vuelo::query()
            ->leftJoin('tiempos_operativos as t', 't.vuelo_id', '=', 'vuelos.id')
            ->leftJoin('demoras as d', 'd.vuelo_id', '=', 'vuelos.id')
            ->leftJoin('operadores as o', 'o.id', '=', 'vuelos.operador_id')
            ->select([
                // ==== Aliases para que tu Blade NO cambie ====
                'vuelos.id as id_control_aeronave',
                'vuelos.fecha as fecha',
                DB::raw("COALESCE(vuelos.numero_vuelo_llegando, vuelos.numero_vuelo_saliendo) as numero_vuelo"),
                'vuelos.origen as origen',
                'vuelos.destino as destino',
                'vuelos.hora_llegada_real as hora_llegada',
                'vuelos.posicion_llegada as posicion_llegada',
                'vuelos.matricula as matricula_operador',
                'vuelos.total_pax as total_pax',
                'vuelos.hora_salida_itinerario as salida_itinerario',
                'vuelos.hora_salida_pushback as hora_real_salida',

                // tiempos (detalle)
                't.desabordaje_inicio',
                't.desabordaje_fin',
                't.inspeccion_cabina_inicio',
                't.inspeccion_cabina_fin',
                't.aseo_ingreso',
                't.aseo_salida',
                't.tripulacion_ingreso',
                't.abordaje_inicio',
                't.abordaje_fin',
                't.cierre_puerta',

                // demoras (detalle)
                'd.minutos as demora_tiempo',
                'd.motivo as demora_motivo',
            ]);

        // ==== Filtros como en tu Blade ====
        if ($request->filled('numero_vuelo')) {
            $nv = $request->input('numero_vuelo');
            $q->where(function($w) use ($nv) {
                $w->where('vuelos.numero_vuelo_llegando', 'like', "%{$nv}%")
                  ->orWhere('vuelos.numero_vuelo_saliendo', 'like', "%{$nv}%");
            });
        }
        if ($request->filled('fecha')) {
            $q->whereDate('vuelos.fecha', $request->input('fecha'));
        }

        $items = $q->orderByDesc('vuelos.id')->paginate($perPage);

        return view('controlaeronave.index', compact('items'));
    }

    /* ===========================
     *  ACCESOS (modal)
     * =========================== */

    // Lista para el modal (JSON que consumen tus funciones JS)
    public function accesosIndex($vueloId)
    {
        $rows = Accesos::where('vuelo_id', $vueloId)
            ->orderByDesc('id')
            ->get([
                'id',
                'nombre',
                'identificacion',   // en DB
                'hora_entrada',
                'hora_salida',
                'hora_entrada1',
                'hora_salida1',
                'herramientas',
                'empresa',
                'motivo_entrada',
                'firma_path'
            ])
            // renombramos para que el JS que hiciste no cambie
            ->map(function ($r) {
                return [
                    'id'             => $r->identificacion, // el JS espera "id"
                    'nombre'         => $r->nombre,
                    'hora_entrada'   => optional($r->hora_entrada)->format('H:i'),
                    'hora_salida'    => optional($r->hora_salida)->format('H:i'),
                    'hora_entrada1'  => optional($r->hora_entrada1)->format('H:i'),
                    'hora_salida1'   => optional($r->hora_salida1)->format('H:i'),
                    'herramientas'   => $r->herramientas,
                    'empresa'        => $r->empresa,
                    'motivo'         => $r->motivo_entrada,
                    'firma'          => $r->firma_path,
                ];
            });

        return response()->json($rows);
    }

   

    public function accesosDestroy(Accesos $acceso)
    {
        if ($acceso->firma_path && Storage::disk('public')->exists($acceso->firma_path)) {
            Storage::disk('public')->delete($acceso->firma_path);
        }
        $acceso->delete();
        return response()->json(['ok' => true]);
    }

    /* ===========================
     *  CRUD principal (no usados ahora)
     *  Los dejo como placeholders seguros.
     * =========================== */

      public function create()
    {
    
        return view('/controlaeronave/create');
    }


    public function edit1($id)
    {
        $vuelo = vuelo::findOrFail($id);
        return view('controlaeronave.edit', compact('vuelo')); // si luego lo usas
    }




       public function create1(Request $request)
        {
            $vuelo = null;
            if ($request->filled('vuelo_id')) {
                $vuelo = vuelo::findOrFail($request->vuelo_id);
            }

            $operadores = Operador::orderBy('nombre')->get(['id','codigo','nombre']);
            return view('controlaeronave.create', compact('operadores','vuelo'));
        }

      public function store1(Request $request)
        {
            $data = $request->validate([
                'vuelo_id'                      => 'required|exists:vuelos,id',

                // OPERADOR (array)
                'operador.codigo'               => 'required|string|max:50',
                'operador.nombre'               => 'required|string|max:100',

                // TIEMPOS (array)
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

                // DEMORAS (array)
                'demoras.motivo'                  => 'nullable|string|max:200',
                'demoras.minutos'                 => 'nullable|integer|min:0',
                'demoras.agente_id'               => 'nullable|integer',
            ]);

            DB::transaction(function () use ($request, $data) {

                $vuelo = vuelo::lockForUpdate()->findOrFail($data['vuelo_id']);

                // Operador: crear o reutilizar y vincular
                $codigo = data_get($data, 'operador.codigo');
                $nombre = data_get($data, 'operador.nombre');

                $operador = Operador::firstOrCreate(
                    ['codigo' => $codigo],
                    ['nombre' => $nombre]
                );

                if ($vuelo->operador_id !== $operador->id) {
                    $vuelo->operador_id = $operador->id;
                    $vuelo->save();
                }

                // Tiempos 1:1
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

                // Demora (una por ahora)
                $d = $request->input('demoras', []);
                if (!empty($d['motivo']) || ($d['minutos'] ?? null) !== null) {
                    demoras::create([
                        'vuelo_id'  => $vuelo->id,
                        'motivo'    => $d['motivo']    ?? null,
                        'minutos'   => (int)($d['minutos'] ?? 0),
                        'agente_id' => $d['agente_id'] ?? null,
                    ]);
                }
            });

            return redirect()
                ->route('admin.controlaeronave.index')
                ->with('success', 'Operador, tiempos y demora registrados para el vuelo.');
        }
}