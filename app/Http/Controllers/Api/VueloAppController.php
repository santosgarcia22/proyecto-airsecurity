<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vuelo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Operador;

class VueloAppController extends Controller
{
    //
   // GET /api/v1/vuelos?numero=AV123&fecha=2025-08-01&page=1
    public function index(Request $request)
    {
        $q = vuelo::query();

        if ($nv = $request->query('numero')) {
            $q->where(function($w) use ($nv) {
                $w->where('numero_vuelo_llegando', 'like', "%{$nv}%")
                  ->orWhere('numero_vuelo_saliendo', 'like', "%{$nv}%");
            });
        }
        if ($f = $request->query('fecha')) {
            $q->whereDate('fecha', $f);
        }

        $rows = $q->orderByDesc('id')->paginate(20);

        return response()->json([
            'ok'   => true,
            'data' => $rows,
        ]);
    }

    // GET /api/v1/vuelos/{vuelo}
    public function show(vuelo $vuelo)
    {
        $vuelo->load(['tiempos', 'demoras', 'accesos']); // si tienes relaciones en el modelo
        return response()->json(['ok' => true, 'data' => $vuelo]);
    }


     public function store(Request $request)
    {
        $data = $request->validate([
            // básicos
            'fecha'                   => ['required','date'],                  // YYYY-MM-DD
            'origen'                  => ['nullable','string','max:10'],
            'destino'                 => ['nullable','string','max:10'],

            // al menos uno de los dos números
            'numero_vuelo_llegando'   => ['nullable','string','max:20','required_without:numero_vuelo_saliendo'],
            'numero_vuelo_saliendo'   => ['nullable','string','max:20','required_without:numero_vuelo_llegando'],

            'matricula'               => ['nullable','string','max:20'],
            'posicion_llegada'        => ['nullable','string','max:20'],

            // vincular operador (2 opciones: por id o por codigo+nombre)
            'operador_id'             => ['nullable','integer','exists:operadores,id'],
            'operador_codigo'         => ['nullable','string','max:50'],
            'operador_nombre'         => ['nullable','string','max:100'],

            // tiempos del vuelo (opcional). Aceptamos "HH:MM" o "YYYY-MM-DD HH:MM"
            'hora_llegada_real'       => ['nullable','string','max:16'],
            'hora_salida_itinerario'  => ['nullable','string','max:16'],
            'hora_salida_pushback'    => ['nullable','string','max:16'],

            'total_pax'               => ['nullable','integer','min:0'],
        ]);

        // helper: convierte "HH:MM" a "YYYY-MM-DD HH:MM" usando 'fecha'
        $mergeDate = function (?string $hm, string $fecha) {
            if (!$hm) return null;
            // Si ya viene con fecha, la respetamos
            if (preg_match('/^\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}$/', $hm)) {
                return Carbon::parse($hm)->format('Y-m-d H:i:s');
            }
            // Si viene "HH:MM"
            if (preg_match('/^\d{2}:\d{2}$/', $hm)) {
                return Carbon::parse("{$fecha} {$hm}:00")->format('Y-m-d H:i:s');
            }
            // último intento: parse genérico (por si la app manda ISO)
            return Carbon::parse($hm)->format('Y-m-d H:i:s');
        };

        $created = DB::transaction(function () use ($data, $mergeDate) {

            // 1) Operador (si no dan operador_id)
            $operadorId = $data['operador_id'] ?? null;
            if (!$operadorId && !empty($data['operador_codigo'])) {
                $operador = Operador::firstOrCreate(
                    ['codigo' => $data['operador_codigo']],
                    ['nombre' => $data['operador_nombre'] ?? $data['operador_codigo']]
                );
                $operadorId = $operador->id;
            }

            // 2) Normalizar tiempos (si vienen tipo "HH:MM")
            $fecha = $data['fecha'];
            $hlr  = $mergeDate($data['hora_llegada_real']      ?? null, $fecha);
            $hsi  = $mergeDate($data['hora_salida_itinerario'] ?? null, $fecha);
            $hsp  = $mergeDate($data['hora_salida_pushback']   ?? null, $fecha);

            // 3) Crear vuelo
            $row = vuelo::create([
                'fecha'                  => $fecha,
                'origen'                 => $data['origen']                  ?? null,
                'destino'                => $data['destino']                 ?? null,
                'numero_vuelo_llegando'  => $data['numero_vuelo_llegando']   ?? null,
                'numero_vuelo_saliendo'  => $data['numero_vuelo_saliendo']   ?? null,
                'matricula'              => $data['matricula']               ?? null,
                'operador_id'            => $operadorId,
                'posicion_llegada'       => $data['posicion_llegada']        ?? null,
                'hora_llegada_real'      => $hlr,
                'hora_salida_itinerario' => $hsi,
                'hora_salida_pushback'   => $hsp,
                'total_pax'              => $data['total_pax']               ?? null,
            ]);

            return $row;
        });

        return response()->json([
            'ok'   => true,
            'id'   => $created->id,
            'data' => $created,
        ], 201);
    }
}