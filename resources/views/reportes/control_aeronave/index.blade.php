@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
<style>
.card {
    padding: 35px;
}

.card-header-custom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap
}

.table thead th {
    vertical-align: middle;
    text-align: center;
    white-space: nowrap
}

.table-responsive {
    margin-top: 5px
}

.container {
    display: flex;
    align-items: center
}
</style>
@endsection

<div class="card">
    <div class="container">
        <h5 class="mb-0 font-weight-bold">Reporte de Control Accesos Aeronave</h5>
    </div>

    <div class="card-header card-header-custom">
        <form method="GET" action="{{ route('reportes.control_aeronave.index') }}" class="form-inline">
            <label class="mr-2 font-weight-bold">Desde:</label>
            <input type="date" name="fecha_inicio" class="form-control mr-2" value="{{ request('fecha_inicio') }}">

            <label class="mr-2 font-weight-bold">Hasta:</label>
            <input type="date" name="fecha_fin" class="form-control mr-2" value="{{ request('fecha_fin') }}">

            <label class="mr-2 font-weight-bold">Buscar:</label>
            <input id="busqueda-input" type="text" name="q" class="form-control ml-2" style="min-width:260px"
                value="{{ request('q') }}" placeholder="Buscar vuelo, origen, persona, empresa, ...">

            <button type="submit" class="btn btn-primary ml-2">Filtrar</button>
        </form>

        <!-- <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">Exportar</button>
            <div class="dropdown-menu dropdown-menu-right">
                {{-- Exportación global a Excel respetando filtros --}}
                <a class="dropdown-item" target="_blank"
                    href="{{ route('reportes.accesos.excel', request()->only('fecha_inicio','fecha_fin','q')) }}">
                    Exportar a Excel
                </a>
            </div>
        </div> -->
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">Lista</div>

        <div class="card-body">
            <div class="table-responsive" id="tabla-contenido">
                <!-- aquí se carga la tabla por AJAX si aplica -->
            </div>

            <div class="table-responsive">
                <table id="tabla-accesos" class="table table-bordered table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Número Vuelo</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Matrícula</th>
                            <th>Coordinador</th>
                            <th class="text-center">Exportar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $i => $row)
                        @php
                        $idPdf = \App\Models\ControlAero::whereDate('fecha',
                        \Carbon\Carbon::parse($row->fecha)->toDateString())
                        ->where('numero_vuelo', $row->numero_vuelo)
                        ->min('id_control_aeronave');
                        @endphp
                        <tr>
                            <td>{{ $data->firstItem() + $i }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->fecha)->format('Y-m-d') }}</td>
                            <td>{{ $row->numero_vuelo }}</td>
                            <td>{{ $row->origen }}</td>
                            <td>{{ $row->destino }}</td>
                            <td>{{ $row->matricula_operador }}</td>
                            <td>{{ $row->coordinador_lider }}</td>
                            <td class="text-center">
                                <a class="btn btn-dark btn-sm" target="_blank"
                                    href="{{ route('reportes.control_aeronave.pdf', ['id' => $row->id]) }}">
                                    PDF
                                </a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Sin resultados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $data->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loader"
    style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.7);z-index:9999;justify-content:center;align-items:center;">
    <div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando...</span></div>
</div>

@section('archivos-js')
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

<script>
$(function() {
    // búsqueda instantánea opcional
    $('#busqueda-input').on('input', function() {
        $.get("{{ route('reportes.accesos.buscar') }}", {
            q: this.value
        }, function(html) {
            $('#tabla-contenido').html(html);
        }).fail(function(xhr) {
            console.error(xhr.responseText);
            toastr.error('Error al buscar');
        });
    });

    // animación de paginación
    document.querySelectorAll(".pagination a").forEach(a => {
        a.addEventListener("click", function(e) {
            e.preventDefault();
            const loader = document.getElementById("loader");
            loader.style.display = "flex";
            setTimeout(() => {
                window.location.href = this.href;
            }, 600);
        });
    });
});
</script>
@endsection