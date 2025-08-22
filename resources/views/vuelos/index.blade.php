@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
<style>
.card {
    padding: 25px;
}

.card-header-custom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    background: #0d6efd;
    /* Azul */
    color: white;
    padding: 5px 10px;
    border-radius: 5px 5px 0 0;
}

.card-header-custom h5 {
    margin: 0;
    font-weight: bold;
}

.table thead th {
    background: #0d6efd !important;
    /* Azul encabezado */
    color: white !important;
    text-align: center;
}

#modal {
    margin: 0 0 0 20px;
}
</style>
@endsection

<div class="card">
    <div class="card-header-custom">
        <h5 class="mb-0">Lista de Vuelos</h5>

    </div>

    <div class="card-body">
        <form class="row mb-3" method="GET" action="{{ route('admin.vuelo.index') }}">
            <!-- <div class="col-md-2">
                <label>Mostrar</label>
                <select name="limit" class="form-control">
                    <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25</option>
                </select>
            </div> -->

            <div class="col-md-2">
                <label>Desde</label>
                <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
            </div>

            <div class="col-md-2">
                <label>Hasta</label>
                <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
            </div>

            <div class="col-md-4">
                <label>Buscar</label>
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Buscar..." value="{{ request('q') }}">
                    <button class="btn btn-primary">Buscar</button>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-end justify-content-end gap-2">
                <a href="{{ route('admin.vuelo.create') }}" class="btn btn-outline-primary btn-sm">Nuevo vuelo</a>
                <button type="button" id="modal" class="btn btn-outline-success btn-sm" data-toggle="modal"
                    data-target="#modalOperadores">
                    Administrar Operadores
                </button>
            </div>

        </form>




        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>N° Llegando</th>
                        <th>N° Saliendo</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Matrícula</th>
                        <th>Operador</th>
                        <th style="width:130px">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vuelos as $v)
                    <tr>
                        <td>{{ optional($v->fecha)->format('Y-m-d') }}</td>
                        <td>{{ $v->numero_vuelo_llegando }}</td>
                        <td>{{ $v->numero_vuelo_saliendo }}</td>
                        <td>{{ $v->origen }}</td>
                        <td>{{ $v->destino }}</td>
                        <td>{{ $v->matricula }}</td>
                        <td>{{ optional($v->operador)->nombre }}</td>
                        <td class="text-center">
                            <a class="btn btn-xs btn-info" href="{{ route('admin.vuelo.show',$v) }}">Ver</a>
                            <a class="btn btn-xs btn-warning" href="{{ route('admin.vuelo.edit',$v) }}">Editar</a>
                            <form action="{{ route('admin.vuelo.destroy',$v) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Eliminar vuelo?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-xs btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No se encontraron registros</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $vuelos->links() }}
        </div>
    </div>
</div>
<!-- Botón para abrir modal -->


<!-- Modal -->
<div class="modal fade" id="modalOperadores" tabindex="-1" aria-labelledby="modalOperadoresLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalOperadoresLabel">Operadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">
                <!-- Formulario crear -->
                <form id="formOperador" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-3">
                        <input type="text" name="codigo" class="form-control" placeholder="Código" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre operador" required>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success w-100">Agregar</button>
                    </div>
                </form>

                <!-- Tabla de operadores -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="tablaOperadores">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th style="width:100px">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Operador::orderBy('nombre')->get() as $op)
                            <tr data-id="{{ $op->id }}">
                                <td>{{ $op->codigo }}</td>
                                <td>{{ $op->nombre }}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm btn-eliminar"
                                        data-url="{{ route('admin.operador.destroy', $op->id) }}"
                                        data-token="{{ csrf_token() }}">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/delete.js') }}"></script>


<script>
$(function() {
    // Crear operador
    $('#formOperador').on('submit', function(e) {
        e.preventDefault();
        $.post("{{ route('admin.operador.store') }}", $(this).serialize(), function() {
            cargarOperadores();
            $('#formOperador')[0].reset();
        });
    });

    // Borrar operador
    $(document).on('click', '.btnBorrar', function() {
        if (!confirm("¿Eliminar operador?")) return;
        let id = $(this).data('id');
        $.ajax({
            url: "/admin/operadores/" + id,
            type: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {
                cargarOperadores();
            }
        });
    });

    // Recargar tabla operadores
    function cargarOperadores() {
        $.get("{{ route('admin.operador.index') }}", function(data) {
            let rows = "";
            data.forEach(op => {
                rows += `
        <tr data-id="${op.id}">
          <td>${op.codigo}</td>
          <td>${op.nombre}</td>
          <td class="text-center">
            <button class="btn btn-danger btn-sm btn-eliminar"
                    data-url="/admin/operadores/${op.id}"
                    data-token="{{ csrf_token() }}">
              Eliminar
            </button>
          </td>
        </tr>`;
            });
            $("#tablaOperadores tbody").html(rows);

            // Re-vincula los listeners del delete.js para los nuevos botones
            document.querySelectorAll('.btn-eliminar').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // dispara el mismo flujo que en delete.js
                    // O más simple: vuelve a cargar delete.js o factoriza a una función global.
                });
            });
        });
    }

});
</script>