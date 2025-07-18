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
                <form action="{{ route('admin.accesos.update', $acceso->numero_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $acceso->nombre }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control" required>
                                <option value="">Seleccione un tipo...</option>
                                @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id_tipo }}"
                                    {{ $acceso->tipo == $tipo->id_tipo ? 'selected' : '' }}>
                                    {{ $tipo->nombre_tipo }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="posicion" class="form-label">Posición</label>
                            <input type="text" name="posicion" class="form-control" value="{{ $acceso->posicion }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" name="id" class="form-control" value="{{ $acceso->id }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Ingreso</label>
                            <input type="datetime-local" name="ingreso" class="form-control"
                                value="{{ \Carbon\Carbon::parse($acceso->ingreso)->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Salida (fecha y hora)</label>

                            <input type="datetime-local" name="salida" class="form-control"
                                value="{{ $acceso->salida ? \Carbon\Carbon::parse($acceso->salida)->format('Y-m-d\TH:i') : '' }}">

                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sincronización</label>
                            <input type="datetime-local" name="Sicronizacion" class="form-control"
                                value="{{ $acceso->Sicronizacion ? \Carbon\Carbon::parse($acceso->Sicronizacion)->format('Y-m-d\TH:i') : '' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Objetos (imagen)</label>
                        <input type="file" name="objetos" class="form-control"
                            accept="image/png, image/jpeg, image/jpg, image/webp, image/bmp, image/tiff, image/heic"
                            required>
                        <small class="text-muted">Archivo actual: {{ $acceso->objetos }}</small>
                    </div>

                    <label class="form-label">Número de Vuelo</label>
                    <select name="vuelo" class="form-control" required>
                        @foreach ($vuelo as $v)
                        <option value="{{ $v->id_vuelo }}" {{ $v->id_vuelo == $acceso->vuelo ? 'selected' : '' }}>
                            {{ $v->numero_vuelo }}
                        </option>
                        @endforeach
                    </select>
<br>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('admin.accesos.show') }}" class="btn btn-secondary">Cancelar</a>
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