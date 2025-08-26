@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@endsection


<div class="card">
    <div class="container">
        <div class="card-header bg-primary text-white">Nuevo Vuelo</div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.vuelo.store') }}"  >
                @csrf
                @include('vuelos.partials.form', ['mode'=>'create'])
                <button class="btn btn-primary">Guardar</button>
                <a class="btn btn-secondary" href="{{ route('admin.vuelo.index') }}">Cancelar</a>
            </form>
        </div>
    </div>


</div>


<style>
.card{
  padding: 40px 0 0 0;
}  


/* .container{

  border: 1px solid;
}
  */
</style>