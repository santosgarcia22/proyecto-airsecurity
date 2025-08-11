<?php

namespace App\Exports;

use App\Models\tipo;
use Maatwebsite\Excel\Concerns\FromCollection;

class TiposExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return tipo::all();
    }


    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = tipo::query();

        if ($this->request->filled('fecha_inicio') && $this->request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [
                $this->request->input('fecha_inicio') . ' 00:00:00',
                $this->request->input('fecha_fin') . ' 23:59:59'
            ]);
        }

        $data = $query->orderBy('id_tipo', 'desc')->get();

        return view('reportes.exports.tipos-excel', compact('data'));
    }
}