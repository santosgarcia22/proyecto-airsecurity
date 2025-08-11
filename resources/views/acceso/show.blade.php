<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.content {
    padding: 10px;
}

.img-miniatura:hover {
    box-shadow: 0 0 8px #007bff44;
    transition: box-shadow 0.2s;
    border-radius: 5px;
}

@media (max-width: 576px) {

    th,
    td {
        font-size: 12px;
        padding: 0.4rem;
    }

    .col-sincronizacion,
    .col-usuario,
    .col-objetos {
        display: none;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    td img {
        max-width: 40px !important;
        max-height: 40px !important;
    }

    .btn-text {
        display: none;
    }
}

@media (max-width: 768px) {
    .d-flex.flex-wrap.gap-2.w-100 {
        flex-direction: column !important;
        align-items: stretch !important;
    }
}
</style>

<section class="content">

    {{-- Modal para ver imagen en grande y descargar --}}
    <div class="modal fade" id="imagenModal" tabindex="-1" aria-labelledby="imagenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImagen" src="" alt="Imagen" style="max-width:100%; max-height:70vh;">
                    <br>
                    <a id="descargarImagen" href="#" class="btn btn-outline-primary mt-3" download target="_blank">
                        <i class="bi bi-download"></i> Descargar imagen
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-3">


        @if(request('busqueda') || request('numero_vuelo'))
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
            <div id="toastFiltro" class="toast align-items-center text-bg-info border-0 show" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        @if(request('busqueda'))
                        <i class="bi bi-search"></i> Búsqueda: <b>{{ request('busqueda') }}</b>
                        @endif
                        @if(request('numero_vuelo'))
                        <i class="bi bi-airplane"></i> Vuelo: <b>{{ request('numero_vuelo') }}</b>
                        @endif
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        onclick="window.location='{{ route('admin.accesos.index') }}'"></button>
                </div>
            </div>
        </div>
        @endif




        @if ($errors->has('objetos'))
        <div class="alert alert-danger">
            {{ $errors->first('objetos') }}
        </div>
        @endif

        @if($numeroVuelo)
        <div class="alert alert-info mb-2">
            Mostrando accesos para el vuelo <b>{{ $numeroVuelo }}</b>
        </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <span class="fw-bold">Lista de Accesos</span>
            </div>

            <div class="card-body">
                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <form method="GET" action="{{ route('admin.accesos.index') }}" class="d-flex align-items-center">
                        <label class="me-2 mb-0">Mostrar</label>
                        <select name="per_page" onchange="this.form.submit()" class="form-select form-select-sm w-auto">
                            @foreach([5, 10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 5) == $size ? 'selected' : '' }}>
                                {{ $size }}</option>
                            @endforeach
                        </select>
                        <label class="ms-2 mb-0">registros</label>
                        @if(request('busqueda'))
                        <input type="hidden" name="busqueda" value="{{ request('busqueda') }}">
                        @endif
                        @if(request('numero_vuelo'))
                        <input type="hidden" name="numero_vuelo" value="{{ request('numero_vuelo') }}">
                        @endif
                    </form>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                    <form method="GET" action="{{ route('admin.accesos.index') }}" class="d-flex flex-wrap gap-2 w-100">
                        <input type="text" name="busqueda" class="form-control form-control-sm" placeholder="Buscar..."
                            value="{{ request('busqueda') }}" style="max-width: 210px;">
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="bi bi-search"></i> Buscar
                        </button>

                        <select name="numero_vuelo" class="form-select form-select-sm" style="max-width: 170px;"
                            onchange="this.form.submit()">
                            <option value="">✈️-- Todos los vuelos --</option>
                            @foreach($vuelos as $vuelo)
                            <option value="{{ $vuelo->numero_vuelo }}"
                                {{ request('numero_vuelo') == $vuelo->numero_vuelo ? 'selected' : '' }}>
                                {{ $vuelo->numero_vuelo }}
                            </option>
                            @endforeach
                        </select>


                    </form>
                    <a href="{{ route('admin.accesos.create') }}" class="btn btn-outline-primary btn-sm ms-auto">
                        <i class="bi bi-pencil-square"></i> Nuevo Acceso
                    </a>

                    <a href="{{ route('admin.reporte.uno') }}" target="_blank"
                        class="btn btn-outline-primary btn-sm ms-auto">
                        <i class="bi bi-pencil-square"></i> Reporte Acceso pdf
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Posición</th>
                                <th>Ingreso</th>
                                <th>Salida</th>
                                <th>Usuario</th>
                                <th>Vuelo</th>
                                <th>Objetos</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($acceso as $item)
                            <tr>
                                <td>{{ $item->numero_id }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->nombre_tipo }}</td>
                                <td>{{ $item->posicion }}</td>
                                <td>{{ $item->ingreso }}</td>
                                <td>{{ $item->salida }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->numero_vuelo }}</td>
                                <td>
                                    @if($item->objetos)
                                    <img src="{{ asset('storage/objetos/' . basename($item->objetos)) }}" alt="Imagen"
                                        class="img-miniatura"
                                        style="max-width: 50px; max-height: 50px; object-fit: cover; cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#imagenModal"
                                        data-imagen="{{ asset('storage/objetos/' . basename($item->objetos)) }}">
                                    @else
                                    <span class="text-muted">No hay imagen</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.accesos.edit', $item->numero_id) }}"
                                        class="btn btn-sm btn-info me-1">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-eliminar"
                                        data-url="{{ route('admin.accesos.destroy', $item->numero_id) }}"
                                        data-token="{{ csrf_token() }}">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">No se encontraron registros</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>
                        Mostrando registros del {{ $acceso->firstItem() }} al {{ $acceso->lastItem() }} de un total de
                        {{ $acceso->total() }} registros
                    </div>
                    <div>
                        {{ $acceso->appends(request()->all())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var imagenModal = document.getElementById('imagenModal');
    if (imagenModal) {
        imagenModal.addEventListener('show.bs.modal', function(event) {
            var trigger = event.relatedTarget;
            if (trigger && trigger.getAttribute('data-imagen')) {
                var imagenSrc = trigger.getAttribute('data-imagen');
                document.getElementById('modalImagen').src = imagenSrc;
                document.getElementById('descargarImagen').href = imagenSrc;
            }
        });
    }
});
</script>

{{-- Scripts extra --}}
@yield('scripts')
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/delete.js') }}"></script>
@section('archivos-js')
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
@endsection