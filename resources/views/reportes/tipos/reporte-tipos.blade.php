@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@stop


<div class="container">
    <form method="GET" action="{{ route('reportes.tipos') }}" class="form-inline mb-3">
        <label class="mr-2">Desde:</label>
        <input type="date" name="fecha_inicio" class="form-control mr-2" value="{{ request('fecha_inicio') }}">

        <label class="mr-2">Hasta:</label>
        <input type="date" name="fecha_fin" class="form-control mr-2" value="{{ request('fecha_fin') }}">

        <button type="submit" class="btn btn-primary mr-2">Filtrar</button>

        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">
                Exportar
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" target="_blank"
                    href="{{ route('reportes.tipos.pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}">
                    PDF Export
                </a>
                <a class="dropdown-item" target="_blank"
                    href="{{ route('reportes.tipos.excel', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}">
                    Excel Export
                </a>
            </div>
        </div>
    </form>

</div>
<div class="card">
    <div class="card-header bg-primary text-white font-weight-bold">Lista de Tipos</div>
    <div class="card-body">
        <input type="text" id="buscador-tipos" class="form-control mb-3" placeholder="Buscar por nombre...">
        <div id="contenedor-tabla-tipos">
            @include('reportes.tipos.tabla-tipos', ['data' => $data])
        </div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('content-admin-js')
<script>
$('#buscador-tipos').on('keyup', function() {
    let q = $(this).val();
    $.get("{{ route('reportes.tipos.buscar') }}", {
        q: q
    }, function(data) {
        $('#contenedor-tabla-tipos').html(data);
    }).fail(() => alert('Error al buscar.'));
});
</script>
@stop