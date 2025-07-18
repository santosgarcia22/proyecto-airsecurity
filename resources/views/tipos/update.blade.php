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
<!-- style="display: none" para ocultarlo dinamincamente -->
<div id="divcontenedor"  >
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Actualizar Tipo</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tipo.update', $tipo->id_tipo) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre_tipo" class="form-label">Nombre</label>
                            <input type="text" name="nombre_tipo" class="form-control" value="{{ $tipo->nombre_tipo }}"
                                @if($relacionado) readonly @endif required>
                            @if($relacionado)
                            <small class="text-danger">No puedes editar el nombre porque ya está relacionado a un
                                acceso.</small>
                            @endif
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('admin.tipo.show') }}" class="btn btn-primary">Cancelar</a>
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


@stop