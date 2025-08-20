@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
<style>
.card-header-custom{display:flex;gap:10px;align-items:center;justify-content:space-between;flex-wrap:wrap}
</style>
@endsection

<div class="card">
  <div class="card-header card-header-custom">
    <h5 class="mb-0 font-weight-bold">Vuelos</h5>

    <form class="form-inline" method="GET" action="{{ route('admin.vuelo.index') }}">
      <label class="mr-2">Desde</label>
      <input type="date" name="fecha_inicio" class="form-control mr-2" value="{{ request('fecha_inicio') }}">
      <label class="mr-2">Hasta</label>
      <input type="date" name="fecha_fin" class="form-control mr-2" value="{{ request('fecha_fin') }}">
      <input type="text" name="q" class="form-control mr-2" placeholder="Buscar..." value="{{ request('q') }}" style="min-width:240px">
      <button class="btn btn-primary">Filtrar</button>
      <a href="{{ route('admin.vuelo.create') }}" class="btn btn-success ml-2">Nuevo</a>
    </form>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm table-bordered table-hover">
        <thead class="thead-light">
          <tr>
            <th>Fecha</th>
            <th>N° Llegando</th>
            <th>N° Saliendo</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Matrícula</th>
            <th>Operador</th>
            <th style="width:130px">Acciones</th>
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
            <td>
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
          <tr><td colspan="8" class="text-center">Sin resultados</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-2">
      {{ $vuelos->links() }}
    </div>
  </div>
</div>
