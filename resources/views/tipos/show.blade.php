<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.content {
    padding: 10px;
}

@media (max-width: 576px) {

    th,
    td {
        font-size: 12px;
        padding: 0.4rem;
    }

    /* Oculta columnas menos importantes en móvil */
    .col-sincronizacion,
    .col-usuario,
    .col-objetos {
        display: none;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 576px) {
        td img {
            max-width: 40px !important;
            max-height: 40px !important;
        }
    }

    @media (max-width: 576px) {
        .btn-text {
            display: none;
        }
    }


}
</style>
<section class="content">
    <div class="container-fluid mt-3">


        <!-- Caja azul de filtro/listado -->
        <div class="card shadow-sm">

            <!-- Encabezado principal -->

            <div class="card-header bg-primary text-white d-flex align-items-center">
                <span class="fw-bold">Lista de Tipos</span>

            </div>

            <!-- <div class="card-header bg-primary text-white d-flex align-items-center">

                <form method="GET" action="{{ route('admin.tipo.index') }}" class="ms-auto d-flex align-items-center">
                    <input type="text" name="busqueda" class="form-control form-control-sm me-2" placeholder="Buscar..."
                        value="{{ request('busqueda') }}">
                    <button type="submit" class="btn btn-light btn-sm">Buscar</button>
                </form>

                <a href="{{ route('admin.tipo.create') }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i> Nuevo Tipo
                </a>

            </div> -->

            <div class="card-body">

                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <!-- Selector de cantidad de registros por página -->
                        <form method="GET" action="{{ route('admin.tipo.index') }}" class="d-flex align-items-center">
                            <label class="me-2 mb-0">Mostrar</label>
                            <select name="per_page" onchange="this.form.submit()"
                                class="form-select form-select-sm w-auto">
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
                            <input type="hidden" name="nombre_tipo" value="{{ request('nombre_tipo') }}">
                            @endif

                        </form>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                        <form method="GET" action="{{ route('admin.tipo.index') }}"
                            class="d-flex flex-wrap gap-2 w-100">
                            <!-- Input de búsqueda -->
                            <input type="text" name="busqueda" class="form-control form-control-sm"
                                placeholder="Buscar..." value="{{ request('busqueda') }}" style="max-width: 210px;">

                            <!-- Botón Buscar -->
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </form>

                        <!-- Nuevo Acceso (opcional, muévelo a la derecha) -->
                        <a href="{{ route('admin.tipo.create') }}" class="btn btn-outline-primary btn-sm ms-auto">
                            <i class="bi bi-pencil-square"></i> Nuevo Acceso
                        </a>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tipo as $item)
                                <tr>
                                    <td>{{ $item->id_tipo }}</td>
                                    <td>{{ $item->nombre_tipo }}</td>
                                    <td>
                                        <a href="{{ route('admin.tipo.edit', $item->id_tipo )}}" class="btn btn-sm btn-info me-1">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                    
                                         <button class="btn btn-danger btn-sm btn-eliminar"
                                        data-url="{{ route('admin.tipo.destroy', $item->id_tipo) }}"
                                        data-token="{{ csrf_token() }}">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No se encontraron registros</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pie de página: paginación y resumen 
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>
                      
                    </div>
                    <div>
                       
                    </div>
                </div>-->
                </div>
            </div>
        </div>
</section>

{{-- Scripts --}}
@yield('scripts')


<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/delete.js') }}"></script>

@section('archivos-js')
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

< @endsection