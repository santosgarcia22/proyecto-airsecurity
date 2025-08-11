<?php

namespace App\Exports;

use App\Models\acceso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AccesosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return acceso::all();
    }

    public $data;

    public function __construct($data)
    {
    
        $this->data = $data;
    }

    public function view(): view
    {
        return view('reportes.accesos.excel',['data' => $this->data]);
    }




}
