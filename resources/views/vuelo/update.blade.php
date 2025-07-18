@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
table {
    table-layout: fixed;
}
</style>

<div id="divcontenedor" style="display: none">
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Actualizar Acceso</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vuelo.update', $vuelo->id_vuelo) }}" method="POST">
                    @csrf
                    @method('PUT')


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre del vuelo</label>
                            <input type="text" name="numero_vuelo" class="form-control"
                                value="{{ $vuelo->numero_vuelo }}" @if($relacionado) readonly @endif required>

                            @if($relacionado)
                            <small class="text-danger">No se puede editar el numero de vuelo porque ya esta relacionado
                                a un acceso.</small>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Matricula</label>
                            <input type="text" name="matricula" id="matricula" class="form-control"
                                value="{{$vuelo->matricula}}" required>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Fecha del vuelo</label>
                            <input type="datetime-local" name="fecha" class="form-control"
                                value="{{ $vuelo->fecha ? \Carbon\Carbon::parse($vuelo->fecha)->format('Y-m-d\TH:i') : '' }}">
                        </div>

                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Destino</label>
                            <input type="text" name="destino" id="destino" class="form-control"
                                value="{{ $vuelo->destino }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Origin</label>
                            <input type="text" name="origen" id="origen" class="form-control"
                            value="{{ $vuelo->origen }}" required>
                        </div>

                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('admin.vuelo.show') }}" class="btn btn-secondary">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('archivos-js')
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/alertaPersonalizada.js') }}"></script>

<script>
$(document).ready(function() {
    document.getElementById("divcontenedor").style.display = "block";
});
</script>
@stop