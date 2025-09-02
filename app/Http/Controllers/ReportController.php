<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\acceso;
use App\Models\tipo;
use App\Models\ControlAero;
use App\Exports\AccesosExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\vuelo;               // NUEVO: fuente principal
use App\Models\TiemposOperativos;   // tiempos
use App\Models\demoras;             // demoras
use App\Models\Accesos;    



class ReportController extends Controller
{

    //Vista para el panel de reportes 
        public function vistaPanelReportes()
        {
            return view('reportes.panel');
        }

        //Funcion para los reportes de Accesos en pdf y excel 
        public function reporteAccesosExcel(Request $request)
        {
            $query = acceso::query();

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('ingreso', [
                    $request->fecha_inicio . ' 00:00:00',
                    $request->fecha_fin . ' 23:59:59'
                ]);
            }

            $data = $query->get();

            return Excel::download(new AccesosExport($data), 'reporte_accesos.xlsx');
        }

        public function reporteAccesos(Request $request)
        {
            $query = acceso::query();

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('ingreso', [
                    $request->fecha_inicio . ' 00:00:00',
                    $request->fecha_fin . ' 23:59:59'
                ]);
            }

             $data = $query->orderBy('ingreso', 'Asc')->paginate(5)->appends($request->all());

            return view('reportes.accesos.index', compact('data'));
        }

        public function reporteAccesosPdf(Request $request)
        {
            $query = acceso::with(['tipoRelacion', 'vueloRelacion']);

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('ingreso', [
                    $request->fecha_inicio . ' 00:00:00',
                    $request->fecha_fin . ' 23:59:59'
                ]);
            }

            // Filtro por búsqueda
            if ($request->filled('q')) {
                $busqueda = $request->input('q');
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', "%$busqueda%")
                    ->orWhere('posicion', 'like', "%$busqueda%")
                    ->orWhereHas('tipoRelacion', function ($t) use ($busqueda) {
                        $t->where('nombre_tipo', 'like', '%' . $busqueda . '%');
                    })
                    ->orWhereHas('vueloRelacion', function ($v) use ($busqueda) {
                        $v->where('numero_vuelo', 'like', '%' . $busqueda . '%');
                    });
                });
            }

             $data = $query->orderBy('numero_id', 'asc')->get();

            $pdf = Pdf::loadView('reportes.accesos.pdf', compact('data'))->setPaper('a4', 'landscape');
            return $pdf->stream('reporte_accesos.pdf');
        }

        //Funcion para hacer la busqueda de accesos en los reportes 
      public function buscarAccesos(Request $request)
        {
            $busqueda = $request->get('q');

            $query = \App\Models\acceso::with(['tipoRelacion', 'vueloRelacion']);

            if ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', '%' . $busqueda . '%')
                    ->orWhere('posicion', 'like', '%' . $busqueda . '%')
                    ->orWhereHas('tipoRelacion', function ($t) use ($busqueda) {
                        $t->where('nombre_tipo', 'like', '%' . $busqueda . '%');
                    })
                    ->orWhereHas('vueloRelacion', function ($v) use ($busqueda) {
                        $v->where('numero_vuelo', 'like', '%' . $busqueda . '%');
                    });
                });
            }

            $data = $query->orderByDesc('ingreso')->paginate(5);

            return view('reportes.tabla-accesos', compact('data'))->render();
        }


        // funcion de TIPOS  para la vista 
        public function reporteTipos(Request $request)
        {
            $query = tipo::query();

            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('created_at', [
                    $request->input('fecha_inicio') . ' 00:00:00',
                    $request->input('fecha_fin') . ' 23:59:59'
                ]);
            }

            $data = $query->orderBy('id_tipo', 'desc')->paginate(10);
            return view('reportes.tipos.reporte-tipos', compact('data'));
        }
        public function buscarTipos(Request $request)
        {
            $q = $request->get('q');
            $data = tipo::where('nombre_tipo', 'like', "%$q%")
                ->orderBy('id_tipo', 'desc')
                ->paginate(5);
            return view('reportes.tabla-tipos', compact('data'))->render();
        }
        public function exportarTiposPDF(Request $request)
        {
            $data = $this->filtrarTipos($request)->get();

            $pdf = PDF::loadView('reportes.tipos.tipos-pdf', compact('data'));
            return $pdf->stream('reporte_tipos.pdf');
        }

        public function exportarTiposExcel(Request $request)
        {
            return Excel::download(new \App\Exports\TiposExport($request), 'reporte_tipos.xlsx');
        }

        private function filtrarTipos($request)
        {
            $query = tipo::query();
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('created_at', [
                    $request->input('fecha_inicio') . ' 00:00:00',
                    $request->input('fecha_fin') . ' 23:59:59'
                ]);
            }
            return $query->orderBy('id_tipo', 'desc');
        }




        // Funcion de VUELOS para la vista 
        public function reporteVuelos(Request $request)
            {
                $query = vuelo::query();

                if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                    $query->whereBetween('created_at', [
                        $request->input('fecha_inicio') . ' 00:00:00',
                        $request->input('fecha_fin') . ' 23:59:59'
                    ]);
                }

                  $data = $query->orderBy('id_vuelo', 'desc')->paginate(10);

                return view('reportes.vuelo.reporte-vuelo', compact('data'));
            }

        public function buscarVuelos(Request $request)
            {
                $q = $request->get('q');
                $data = vuelo::where('numero_vuelo', 'like', "%$q%")
                    ->orWhere('destino', 'like', "%$q%")
                    ->orderBy('id', 'desc')
                    ->paginate(5);
                return view('reportes.vuelos.tabla-vuelos', compact('data'))->render();
            }



            public function exportarVuelosPDF(Request $request)
            {
                $data = $this->filtrarVuelos($request)->get();

                $pdf = PDF::loadView('reportes.vuelo.vuelos-pdf', compact('data'));
                return $pdf->stream('reporte_vuelos.pdf');
            }

            public function exportarVuelosExcel(Request $request)
            {
                return Excel::download(new \App\Exports\VuelosExport($request), 'reporte_vuelos.xlsx');
            }

            private function filtrarVuelos($request)
            {
                $query = vuelo::query();
                if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                    $query->whereBetween('created_at', [
                        $request->input('fecha_inicio') . ' 00:00:00',
                        $request->input('fecha_fin') . ' 23:59:59'
                    ]);
                }

                // Filtro por búsqueda
                if ($request->filled('q')) {
                    $busqueda = $request->input('q');
                    $query->where(function ($q) use ($busqueda) {
                        $q->where('numero_vuelo', 'like', "%$busqueda%")
                        ->orWhere('descripcion', 'like', "%$busqueda%");
                    });
                }

                // $data = $query->orderBy('id_vuelo', 'desc')->get();

                return $query->orderBy('id_vuelo', 'Asc');
            }


    // (Opcional) vista HTML normal en el navegador
    public function controlAeronavePreview($id)
    {
        $control = ControlAero::with(['detalles'])->findOrFail($id);
        return view('reportes.control_aeronave.pdf', [
            'control'  => $control,
            'detalles' => $control->detalles,
            'maxRows'  => 32,
            'preview'  => true
        ]);
    }


/* =======================================================
     * LISTADO + FILTROS (una fila por vuelo)
     * ======================================================= */
  public function controlAeronaveIndex(Request $request)
    {
        $q = vuelo::query()
            ->leftJoin('tiempos_operativos as t', 't.vuelo_id', '=', 'vuelos.id')
            ->leftJoin('demoras as d', 'd.vuelo_id', '=', 'vuelos.id');

        // Filtros
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $q->whereBetween('vuelos.fecha', [
                $request->input('fecha_inicio'),
                $request->input('fecha_fin'),
            ]);
        }

        if ($request->filled('q')) {
            $term = $request->input('q');
            $q->where(function ($w) use ($term) {
                $w->where('vuelos.numero_vuelo_llegando', 'like', "%{$term}%")
                  ->orWhere('vuelos.numero_vuelo_saliendo', 'like', "%{$term}%")
                  ->orWhere('vuelos.origen', 'like', "%{$term}%")
                  ->orWhere('vuelos.destino', 'like', "%{$term}%")
                  ->orWhere('vuelos.matricula', 'like', "%{$term}%")
                  // también buscar por campos de accesos
                  ->orWhereExists(function($s) use ($term) {
                      $s->selectRaw(1)
                        ->from('accesos')
                        ->whereColumn('accesos.vuelo_id', 'vuelos.id')
                        ->where(function($z) use ($term){
                            $z->where('accesos.nombre', 'like', "%{$term}%")
                              ->orWhere('accesos.empresa', 'like', "%{$term}%")
                              ->orWhere('accesos.motivo_entrada', 'like', "%{$term}%");
                        });
                  });
            });
        }

        // Selección (alias para que tu blade no cambie mucho)
        $data = $q->select([
                'vuelos.id',
                'vuelos.fecha',
                \DB::raw("COALESCE(vuelos.numero_vuelo_llegando, vuelos.numero_vuelo_saliendo) as numero_vuelo"),
                'vuelos.origen',
                'vuelos.destino',
                'vuelos.matricula as matricula_operador',
                // coordinador_lider ya no existe en el nuevo esquema (si lo necesitas, añade la relación/persona)
                \DB::raw("'' as coordinador_lider"),
            ])
            ->groupBy('vuelos.id','vuelos.fecha','vuelos.numero_vuelo_llegando','vuelos.numero_vuelo_saliendo','vuelos.origen','vuelos.destino','vuelos.matricula')
            ->orderByDesc('vuelos.fecha')
            ->orderByDesc('vuelos.id')
            ->paginate(10);

        return view('reportes.control_aeronave.index', compact('data'));
    }


   /* =======================================================
     * PDF POR VUELO
     * Recibe el ID de vuelo y arma el header + filas de accesos
     * ======================================================= */
   public function controlAeronavePdf($vueloId)
    {
        $vuelo = vuelo::with(['tiempos', 'demoras', 'accesos'])->findOrFail($vueloId);

        // HEADER esperado por tu vista PDF (mismos nombres que usas en la Blade)
        $header = (object) [
            'fecha'               => optional($vuelo->fecha)->format('Y-m-d') ?? $vuelo->fecha,
            'origen'              => $vuelo->origen,
            'destino'             => $vuelo->destino,
            'numero_vuelo'        => $vuelo->numero_vuelo_llegando ?? $vuelo->numero_vuelo_saliendo,
            'total_pax'           => $vuelo->total_pax,
            'hora_llegada'        => $this->hhmm($vuelo->hora_llegada_real),
            'posicion_llegada'    => $vuelo->posicion_llegada,
            'matricula_operador'  => $vuelo->matricula,              // en el nuevo esquema está en vuelos.matricula
            'hora_real_salida'    => $this->hhmm($vuelo->hora_salida_pushback),
            'salida_itinerario'   => $this->hhmm($vuelo->hora_salida_itinerario),

            // tiempos (si existen)
            'desabordaje_inicio'       => optional($vuelo->tiempos)->desabordaje_inicio,
            'desabordaje_fin'          => optional($vuelo->tiempos)->desabordaje_fin,
            'inspeccion_cabina_inicio' => optional($vuelo->tiempos)->inspeccion_cabina_inicio,
            'inspeccion_cabina_fin'    => optional($vuelo->tiempos)->inspeccion_cabina_fin,
            'aseo_ingreso'             => optional($vuelo->tiempos)->aseo_ingreso,
            'aseo_salida'              => optional($vuelo->tiempos)->aseo_salida,
            'tripulacion_ingreso'      => optional($vuelo->tiempos)->tripulacion_ingreso,
            'abordaje_inicio'          => optional($vuelo->tiempos)->abordaje_inicio,
            'abordaje_fin'             => optional($vuelo->tiempos)->abordaje_fin,
            'cierre_puertas'           => optional($vuelo->tiempos)->cierre_puerta,

            // demoras: tomamos la última (o suma si prefieres)
            'demora_tiempo'            => optional($vuelo->demoras->last())->minutos,
            'demora_motivo'            => optional($vuelo->demoras->last())->motivo,

            // seguridad (si en tu nuevo diseño no existen, van nulos)
            'agente_nombre'            => null,
            'agente_id'                => null,
            'agente_firma'             => null,
            'coordinador_lider'        => null,
        ];

        // Filas de personas (accesos) adaptadas al PDF
        $rows = $vuelo->accesos
            ->sortBy('id') // o por hora_entrada si prefieres
            ->values()
            ->map(function($r){
                return (object)[
                    'nombre'         => $r->nombre,
                    'id'             => $r->identificacion,
                    'hora_entrada'   => $r->hora_entrada,
                    'hora_salida'    => $r->hora_salida,
                    'hora_entrada1'  => $r->hora_entrada1,
                    'hora_salida1'   => $r->hora_salida1,
                    'herramientas'   => $r->herramientas,
                    'empresa'        => $r->empresa,
                    'motivo'         => $r->motivo_entrada,
                    'firma_b64'      => $this->img64($r->firma_path),
                ];
            });

        $maxRows = 32;

        $pdf = Pdf::loadView('reportes.control_aeronave.pdf', [
                    'header'  => $header,
                    'rows'    => $rows,
                    'maxRows' => $maxRows,
                ])->setPaper('letter', 'portrait');

        $fecha = $header->fecha ?: Carbon::now()->toDateString();
        return $pdf->stream("control_acceso_aeronave_{$header->numero_vuelo}_{$fecha}.pdf");
    }


        /* =================== helpers =================== */

            // Convierte datetimes a HH:MM (acepta null)
            private function hhmm($v)
            {
                if (!$v) return null;
                try {
                    return Carbon::parse($v)->format('H:i');
                } catch (\Throwable $e) { return null; }
            }

            // Firma a base64 para dompdf
            private function img64(?string $pathRel)
            {
                if (!$pathRel) return null;
                $abs = Storage::disk('public')->path($pathRel);
                if (!is_file($abs)) return null;
                $mime = mime_content_type($abs) ?: 'image/png';
                $data = base64_encode(file_get_contents($abs));
                return "data:{$mime};base64,{$data}";
    }
    
    public function pdf($id)
        {
            // 1. Trae el control con sus accesos ordenados
            $control = controlAero::with(['accesos' => function ($q) {
                $q->orderBy('id_personal');   // o por nombre/hora, como prefieras
            }])->findOrFail($id);

            // 2. (Opcional) convertir firmas a base64 para que dompdf las muestre
            $rows = $control->accesos->map(function ($r) {
                $r->firma_b64 = $this->toBase64($r->firma);
                return $r;
            });

            // 3. Datos para la vista
            $header  = $control;
            $maxRows = 32; // alto fijo de planilla (ajústalo si tu formato usa otro)

            $pdf = Pdf::loadView('reportes.control_aeronave.pdf', compact('header', 'rows', 'maxRows'))
                    ->setPaper('letter', 'portrait'); // o 'legal'/'A4'

            return $pdf->stream("control_acceso_{$control->id_control_aeronave}.pdf");
        }

        private function toBase64(?string $pathRel)
        {
            if (!$pathRel) return null;
            $abs = Storage::disk('public')->path($pathRel);
            if (!is_file($abs)) return null;

            $mime = mime_content_type($abs) ?: 'image/png';
            $data = base64_encode(file_get_contents($abs));
            return "data:$mime;base64,$data";
        }

}