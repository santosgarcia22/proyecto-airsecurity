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
        <div class="card-header bg-primary">Editar Vuelo</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.vuelo.update',$vuelo) }}">
                @csrf @method('PUT')
                @include('vuelos.partials.form', ['mode'=>'edit'])
                <button class="btn btn-danger">Actualizar</button>
                <a class="btn btn-secondary" href="{{ route('admin.vuelo.show',$vuelo) }}">Cancelar</a>
            </form>
        </div>
    </div>
</div>