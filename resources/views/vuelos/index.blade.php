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

            <div class="col-md-2">
                <a href="{{ route('admin.vuelo.create') }}" class="btn btn-outline-primary btn-sm">Nuevo vuelo</a>

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