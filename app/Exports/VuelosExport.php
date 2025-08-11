<?php

namespace App\Exports;

use App\Models\vuelo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VuelosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return vuelo::all();
    }

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = vuelo::query();

        if ($this->request->filled('fecha_inicio') && $this->request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [
                $this->request->input('fecha_inicio') . ' 00:00:00',
                $this->request->input('fecha_fin') . ' 23:59:59'
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

        $data = $query->orderBy('id_vuelo', 'Asc')->get();

        return view('reportes.exports.vuelos-excel', compact('data'));
    }




}