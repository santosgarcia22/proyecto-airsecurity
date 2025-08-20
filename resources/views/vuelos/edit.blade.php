@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@endsection

<div class="card">
  <div class="card-header bg-warning">Editar Vuelo</div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.vuelo.update',$vuelo) }}">
      @csrf @method('PUT')
      @include('vuelos.partials.form', ['mode'=>'edit'])
      <button class="btn btn-warning">Actualizar</button>
      <a class="btn btn-secondary" href="{{ route('admin.vuelo.show',$vuelo) }}">Cancelar</a>
    </form>
  </div>
</div>
