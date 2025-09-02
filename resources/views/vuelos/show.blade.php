@extends('backend.menus.superior')

<style>

  .container{
    padding: 30px 0 0 0;
  }
</style>

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@endsection




<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">Detalle Vuelo</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Fecha</dt>
                <dd class="col-sm-9">{{ optional($vuelo->fecha)->format('Y-m-d') }}</dd>
                <dt class="col-sm-3">Origen/Destino</dt>
                <dd class="col-sm-9">{{ $vuelo->origen }} → {{ $vuelo->destino }}</dd>
                <dt class="col-sm-3">Vuelos</dt>
                <dd class="col-sm-9">{{ $vuelo->numero_vuelo_llegando }} / {{ $vuelo->numero_vuelo_saliendo }}</dd>
                <dt class="col-sm-3">Matrícula</dt>
                <dd class="col-sm-9">{{ $vuelo->matricula }}</dd>
                <dt class="col-sm-3">Operador</dt>
                <dd class="col-sm-9">{{ optional($vuelo->operador)->nombre }}</dd>
                <dt class="col-sm-3">Coordinador</dt>
                <dd class="col-sm-9">{{ optional($vuelo->coordinador)->nombre }}</dd>
                <dt class="col-sm-3">Líder Vuelo</dt>
                <dd class="col-sm-9">{{ optional($vuelo->liderVuelo)->nombre }}</dd>
                <dt class="col-sm-3">Tiempos</dt>
                <dd class="col-sm-9">
                    Llegada real: {{ optional($vuelo->hora_llegada_real)->format('Y-m-d H:i') ?? '—' }} |
                    Salida Itin.: {{ optional($vuelo->hora_salida_itinerario)->format('Y-m-d H:i') ?? '—' }} |
                    Pushback: {{ optional($vuelo->hora_salida_pushback)->format('Y-m-d H:i') ?? '—' }}
                </dd>
            </dl>

            <a class="btn btn-warning" href="{{ route('admin.vuelo.edit',$vuelo) }}">Editar</a>
            <a class="btn btn-secondary" href="{{ route('admin.vuelo.index') }}">Volver</a>
        </div>
    </div>


</div>