<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\acceso;
use App\Models\tipo;
use App\Models\vuelo;
use App\Models\ControlAero;
use App\Exports\AccesosExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

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


 // LISTADO + FILTROS (agrupando por vuelo para no repetir)
    public function controlAeronaveIndex(Request $request)
    {
        $q = controlAero::query();

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $q->whereBetween('fecha', [
                $request->input('fecha_inicio').' 00:00:00',
                $request->input('fecha_fin').' 23:59:59',
            ]);
        }

        if ($request->filled('q')) {
            $term = $request->input('q');
            $q->where(function ($qq) use ($term) {
                $qq->where('numero_vuelo', 'like', "%{$term}%")
                   ->orWhere('origen', 'like', "%{$term}%")
                   ->orWhere('destino', 'like', "%{$term}%")
                   ->orWhere('matricula_operador', 'like', "%{$term}%")
                   ->orWhere('coordinador_lider', 'like', "%{$term}%")
                   ->orWhere('agente_nombre', 'like', "%{$term}%")
                   // buscar también por persona:
                   ->orWhere('nombre', 'like', "%{$term}%")
                   ->orWhere('empresa', 'like', "%{$term}%")
                   ->orWhere('motivo', 'like', "%{$term}%");
            });
        }

        // Agrupamos para listar “un vuelo” por fila en pantalla
        $data = $q->select([
                'fecha','numero_vuelo','origen','destino',
                'matricula_operador','coordinador_lider',
            ])
            ->groupBy('fecha','numero_vuelo','origen','destino','matricula_operador','coordinador_lider')
            ->orderByDesc('fecha')
            ->paginate(10);

        return view('reportes.control_aeronave.index', compact('data'));
    }

    // PDF: toma el id, busca su vuelo y trae TODAS las filas de ese vuelo en esa fecha
    public function controlAeronavePdf($id)
    {
        $base = controlAero::findOrFail($id);

        $fecha = Carbon::parse($base->fecha)->toDateString();

        $rows = controlAero::whereDate('fecha', $fecha)
                ->where('numero_vuelo', $base->numero_vuelo)
                ->orderBy('hora_entrada')
                ->get();

        $header = $rows->first() ?? $base; // para la cabecera
        $maxRows = 32; // filas de la planilla

        $pdf = Pdf::loadView('reportes.control_aeronave.pdf', [
                    'header'  => $header,   // datos del vuelo
                    'rows'    => $rows,     // personas
                    'maxRows' => $maxRows,
                ])->setPaper('letter', 'portrait');

        return $pdf->stream("control_acceso_aeronave_{$header->numero_vuelo}_{$fecha}.pdf");
    }
}