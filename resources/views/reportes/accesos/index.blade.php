@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
<style>
.card-header-custom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.table thead th {
    vertical-align: middle;
    text-align: center;
}

<style>.table thead th {
    vertical-align: middle;
    text-align: center;
    white-space: nowrap;
}

.table-responsive {
    margin-top: 5px;
}

.table thead th {
    vertical-align: middle;
    text-align: center;
}

.container {
    display: flex;
    align-items: center;
}
</style>


@stop

<div class="card">
    <div class="container">
        <h5 class="mb-0 font-weight-bold">Reporte de Accesos</h5>
    </div>
    <div class="card-header card-header-custom">


        <div class="filtros-fechas">
            <form method="GET" action="{{ route('reportes.accesos') }}" class="form-inline">
                <label class="mr-2 font-weight-bold">Desde:</label>
                <input type="date" name="fecha_inicio" class="form-control mr-2" value="{{ request('fecha_inicio') }}">

                <label class="mr-2 font-weight-bold">Hasta:</label>
                <input type="date" name="fecha_fin" class="form-control mr-2" value="{{ request('fecha_fin') }}">

                <button type="submit" class="btn btn-primary">Filtrar</button>

                <label class="mr-2 font-weight-bold">Buscar:</label>
                <div>
                    <input type="text" id="busqueda-input" class="form-control"
                        placeholder="Buscar por nombre, posición o vuelo...">

                </div>
            </form>
        </div>

        <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">
                Exportar
            </button>
            <div class="dropdown-menu dropdown-menu-right">

                <a class="dropdown-item" target="_blank" href="{{ route('reportes.accesos.pdf', [
                        'fecha_inicio' => request('fecha_inicio'),
                        'fecha_fin' => request('fecha_fin'),
                        'q' => request('q')  // filtro de búsqueda
                            ]) }}">
                    Exportar PDF</a>

                <a class="dropdown-item" target="_blank" href="{{ route('reportes.accesos.excel', [
                            'fecha_inicio' => request('fecha_inicio'),
                            'fecha_fin' => request('fecha_fin'),
                            'q' => request('q')  // filtro de búsqueda
                    ]) }}">
                    Exportar a Excel
                </a>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
            Lista
        </div>

        <div class="card-body">
            <div class="card-body">

                <div class="table-responsive" id="tabla-contenido">
                    {{-- aquí se carga la tabla por AJAX --}}
                    @include('reportes.tabla-accesos', ['data' => $data])
                </div>
            </div>

            <!-- <div class="table-responsive">
                <table id="tabla-accesos" class="table table-bordered table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Posición</th>
                            <th>Vuelo</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Sincronización</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->tipo }}</td>
                            <td>{{ $item->posicion }}</td>
                            <td>{{ $item->vuelo }}</td>
                            <td>{{ $item->ingreso }}</td>
                            <td>{{ $item->salida }}</td>
                            <td>{{ $item->Sicronizacion }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $data->appends(request()->query())->links() }}
                </div>

            </div> -->
        </div>
    </div>

    <div id="loader"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; justify-content:center; align-items:center;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
    </div>




    @extends('backend.menus.footerjs')
    @section('archivos-js')


    <script>
    $(document).ready(function() {
        $('#busqueda-input').on('input', function() {
            let query = $(this).val();

            $.ajax({
                url: "{{ route('reportes.accesos.buscar') }}",
                type: "GET",
                data: {
                    q: query
                },
                beforeSend: function() {
                    $('#loader').show(); // tu loader
                },
                success: function(response) {
                    $('#tabla-contenido').html(response);
                    $('#loader').hide();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    toastr.error('Hubo un problema al buscar los resultados.');
                    $('#loader').hide();
                }

            });
        });
    });
    </script>


    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/select2.min.js') }}" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

    @stop

    @section('content-admin-js')


    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".pagination a");
        links.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // Mostrar loader
                document.getElementById("loader").style.display = "flex";

                // Redirigir con retardo de 600ms (ajustable)
                setTimeout(() => {
                    window.location.href = link.href;
                }, 600); // Puedes subirlo a 800 o 1000 si quieres más suavidad
            });
        });
    });
    </script>


    @stop