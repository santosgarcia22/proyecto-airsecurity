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
            'vuelos.id as id_control_aeronave',
            'vuelos.fecha',
            DB::raw("COALESCE(vuelos.numero_vuelo_llegando, vuelos.numero_vuelo_saliendo) as numero_vuelo"),
            'vuelos.origen',
            'vuelos.destino',
            'vuelos.hora_llegada_real as hora_llegada',
            'vuelos.posicion_llegada',
            'vuelos.matricula as matricula_operador',
            'vuelos.total_pax',
            'vuelos.hora_salida_itinerario as salida_itinerario',
            'vuelos.hora_salida_pushback as hora_real_salida',

            // tiempos
            't.desabordaje_inicio','t.desabordaje_fin',
            't.inspeccion_cabina_inicio','t.inspeccion_cabina_fin',
            't.aseo_ingreso','t.aseo_salida','t.tripulacion_ingreso',
            't.abordaje_inicio','t.abordaje_fin','t.cierre_puerta',

            // demoras
            'd.minutos as demora_tiempo','d.motivo as demora_motivo',

            // bandera de encabezado listo
            DB::raw('CASE WHEN t.vuelo_id IS NULL THEN 0 ELSE 1 END as encabezado_ok'),
        ]);

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

 // Edit con Route Model Binding {vuelo}
    public function edit(vuelo $vuelo)
    {
        // Alias para que la vista pueda usar id_control_aeronave
        $vuelo->id_control_aeronave = $vuelo->id;

        // Si quieres, puedes cargar relaciones
        // $vuelo->load('tiemposOperativos');

        return view('controlaeronave.edit', [
            'control' => $vuelo,    // 👈 la vista recibirá $control
        ]);
    }


     public function update(Request $request, vuelo $vuelo)
    {
        // Valida lo básico del vuelo
        $dataVuelo = $request->validate([
            'fecha'             => ['nullable','date'],
            'origen'            => ['nullable','string','max:100'],
            'destino'           => ['nullable','string','max:100'],
            'numero_vuelo'      => ['nullable','string','max:50'],
            'hora_llegada'      => ['nullable'],
            'posicion_llegada'  => ['nullable','string','max:100'],
            'matricula_operador'=> ['nullable','string','max:100'],
            'coordinador_lider' => ['nullable','string','max:150'],
            'total_pax'         => ['nullable','integer','min:0'],
            'hora_real_salida'  => ['nullable'],
        ]);

        // Mapea a columnas reales de tu tabla vuelos
        $vuelo->update([
            'fecha'               => $dataVuelo['fecha'] ?? $vuelo->fecha,
            'origen'              => $dataVuelo['origen'] ?? $vuelo->origen,
            'destino'             => $dataVuelo['destino'] ?? $vuelo->destino,
            'numero_vuelo_llegando' => $dataVuelo['numero_vuelo'] ?? $vuelo->numero_vuelo_llegando, // ajusta según tu modelo
            'hora_llegada_real'   => $dataVuelo['hora_llegada'] ?? $vuelo->hora_llegada_real,
            'posicion_llegada'    => $dataVuelo['posicion_llegada'] ?? $vuelo->posicion_llegada,
            'matricula'           => $dataVuelo['matricula_operador'] ?? $vuelo->matricula,
            'coordinador_lider'   => $dataVuelo['coordinador_lider'] ?? $vuelo->coordinador_lider,
            'total_pax'           => $dataVuelo['total_pax'] ?? $vuelo->total_pax,
            'hora_salida_pushback'=> $dataVuelo['hora_real_salida'] ?? $vuelo->hora_salida_pushback,
        ]);

        // ===== TIEMPOS (si los editas en esta vista) =====
        $t = [
            'desabordaje_inicio'       => $request->input('desabordaje_inicio'),
            'desabordaje_fin'          => $request->input('desabordaje_fin'),
            'inspeccion_cabina_inicio' => $request->input('inspeccion_cabina_inicio'),
            'inspeccion_cabina_fin'    => $request->input('inspeccion_cabina_fin'),
            'aseo_ingreso'             => $request->input('aseo_ingreso'),
            'aseo_salida'              => $request->input('aseo_salida'),
            'tripulacion_ingreso'      => $request->input('tripulacion_ingreso'),
            'abordaje_inicio'          => $request->input('abordaje_inicio'),
            'abordaje_fin'             => $request->input('abordaje_fin'),
            'cierre_puerta'            => $request->input('cierre_puerta'), // 👈 OJO con el nombre (ver nota abajo)
        ];
        if (collect($t)->filter(fn($v)=>$v!==null && $v!=='')->isNotEmpty()) {
            TiemposOperativos::updateOrCreate(['vuelo_id'=>$vuelo->id], $t);
        }

        // ===== DEMORA (si manejas una única por vuelo) =====
        if ($request->filled('demora_tiempo') || $request->filled('demora_motivo')) {
            demoras::updateOrCreate(
                ['vuelo_id'=>$vuelo->id],
                [
                    'minutos' => (int)$request->input('demora_tiempo', 0),
                    'motivo'  => $request->input('demora_motivo'),
                    'agente_id' => $request->input('agente_id'),
                ]
            );
        }

        return redirect()
            ->route('admin.controlaeronave.index')
            ->with('success','Control de aeronave actualizado.');
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
        // DEBUG temporal: mira qué llega
        // logger()->info('payload-create', $request->all());
       // dd($request->only('vuelo_id','tiempos','demoras'));

        $data = $request->validate([
            'vuelo_id' => 'required|exists:vuelos,id',

            // TIEMPOS
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

            // DEMORAS
            'demoras.motivo'    => 'nullable|string|max:200',
            'demoras.minutos'   => 'nullable|integer|min:0',
            'demoras.agente_id' => 'nullable|integer',
        ]);

        DB::transaction(function () use ($request, $data) {
            $vuelo = \App\Models\vuelo::lockForUpdate()->findOrFail($data['vuelo_id']);

            // Guardar/actualizar TIEMPOS (1:1)
            $t = $request->input('tiempos', []);
            if (!empty(array_filter($t, fn($v) => $v !== null && $v !== ''))) {
                \App\Models\TiemposOperativos::updateOrCreate(
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

            // Guardar DEMORA (solo si hay datos)
            $d = $request->input('demoras', []);
            if (!empty($d['motivo']) || ($d['minutos'] ?? null) !== null) {
                \App\Models\demoras::create([
                    'vuelo_id'  => $vuelo->id,
                    'motivo'    => $d['motivo']    ?? null,
                    'minutos'   => (int)($d['minutos'] ?? 0),
                    'agente_id' => $d['agente_id'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.controlaeronave.index', ['open' => $data['vuelo_id']])
            ->with('success', 'Tiempos y demora registrados para el vuelo.');
    }


}