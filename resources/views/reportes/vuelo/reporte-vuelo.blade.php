@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@stop

<style>


    .container{
        padding: 25px;
    }

    .card{
        padding: 25px;
       
    }
</style>

<div class="container">

    <form method="GET" action="{{ route('reportes.vuelos') }}" class="form-inline mb-3">
        <label class="mr-2">Desde:</label>
        <input style=" width: 200px ;"  type="date" name="fecha_inicio" class="form-control mr-2" value="{{ request('fecha_inicio') }}">

        <label class="mr-2">Hasta:</label>
        <input style=" width: 200px ;" type="date" name="fecha_fin" class="form-control mr-2" value="{{ request('fecha_fin') }}">

        <button type="submit" class="btn btn-primary mr-2">Filtrar</button>

        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">
                Exportar
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" target="_blank" href="{{ route('reportes.vuelos.pdf', [
                'fecha_inicio' => request('fecha_inicio'),
                'fecha_fin' => request('fecha_fin'),
                'q' => request('q')  // filtro de búsqueda
                    ]) }}">
                    Exportar PDF
                </a>
                <a class="dropdown-item" target="_blank" href="{{ route('reportes.vuelos.excel', [
                    'fecha_inicio' => request('fecha_inicio'),
                    'fecha_fin' => request('fecha_fin'),
                    'q' => request('q')  // filtro de búsqueda
                    ]) }}">
                    Exportar Excel
                </a>

            </div>
        </div>
    </form>

</div>

<div class="card">
    <div class="card-header bg-primary text-white font-weight-bold">Lista de vuelos</div>
    <div class="card-body">
        <input type="text" id="buscador-vuelo" class="form-control mb-3" placeholder="Buscar por numero...">
        <div id="contenedor-tabla-vuelos">
            @include('reportes.vuelo.tabla-vuelos', ['data' => $data])
        </div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('content-admin-js')
<script>
$('#buscador-vuelos').on('keyup', function() {
    let q = $(this).val();
    $.get("{{ route('reportes.vuelos.buscar') }}", {
        q: q
    }, function(data) {
        $('#contenedor-tabla-vuelos').html(data);
    }).fail(() => alert('Error al buscar.'));
});
</script>
@stop