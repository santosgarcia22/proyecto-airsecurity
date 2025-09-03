@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@endsection


<style>
  .container{
    margin-top:30px;

  }
</style>


<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Nuevo Vuelo
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.vuelo.store') }}">
                @csrf
                @include('vuelos.partials.form', ['mode'=>'create'])

                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary me-2">Guardar</button>
                    <a class="btn btn-secondary" href="{{ route('admin.vuelo.index') }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</div>


