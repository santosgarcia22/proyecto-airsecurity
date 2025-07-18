@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
table {
    /*Ajustar tablas*/
    table-layout: fixed;
}
</style>

<div id="divcontenedor" style="display: none">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Acceso</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.accesos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control" required>
                                <option value="">Seleccione un tipo...</option>
                                @foreach($Tipos as $tipo)
                                <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre_tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="posicion" class="form-label">Posición</label>
                            <input type="text" name="posicion" id="posicion" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_id" class="form-label">ID</label>
                            <input type="text" name="id" id="id" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ingreso" class="form-label">Ingreso (fecha y hora)</label>
                            <input type="datetime-local" name="ingreso" id="ingreso" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="salida" class="form-label">Salida (fecha y hora)</label>
                            <input type="datetime-local" name="salida" id="salida" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="Sincronizacion" class="form-label">Sincronización (fecha y hora)</label>
                            <input type="datetime-local" name="Sicronizacion" id="Sicronizacion" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="objetos" class="form-label">Objetos (subir imagen)</label>
                        <input type="file" name="objetos" id="objetos" class="form-control"
                            accept="image/png, image/jpeg, image/jpg, image/webp, image/bmp, image/tiff, image/heic"
                            required>

                    </div>

                    <div class="mb-3">
                        <label for="vuelo" class="form-label">Número de Vuelo</label>
                        <select name="vuelo" id="vuelo" class="form-control" required>
                            <option value="">Seleccione un vuelo</option>
                            @foreach($vuelo as $v)
                            <option value="{{ $v->id_vuelo }}"
                                {{ (isset($acceso) && $acceso->vuelo == $v->id_vuelo) ? 'selected' : '' }}>
                                {{ $v->numero_vuelo }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Registrar</button>
                        <a href="{{ route('admin.accesos.show') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>

@extends('backend.menus.footerjs')
@section('archivos-js')

<script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/alertaPersonalizada.js') }}"></script>


<!-- incluir tabla -->

<script>
document.querySelector('input[type="file"]').addEventListener('change', function(e) {
    var file = e.target.files[0];
    if (file) {
        var validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            alert('Solo se permiten imágenes JPG, PNG ');
            e.target.value = '';
        }
    }
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    var ruta = "{{ URL::to('/admin/roles/tabla') }}";
    $('#tablaDatatable').load(ruta);
    document.getElementById("divcontenedor").style.display = "block";
});
</script>

<script>
function verInformacion(id) {
    window.location.href = "{{ url('/admin/roles/lista/permisos') }}/" + id;
}

// ver todos los permisos que existen
function vistaPermisos() {
    window.location.href = "{{ url('/admin/roles/permisos/lista') }}";
}

function modalAgregar() {
    document.getElementById("formulario-nuevo").reset();
    $('#modalAgregar').modal('show');
}

function modalBorrar(id) {
    // se obtiene el id del Rol a eliminar globalmente

    $('#idborrar').val(id);
    $('#modalBorrar').modal('show');
}

function borrar() {
    openLoading()
    // se envia el ID del Rol
    var idrol = document.getElementById('idborrar').value;

    var formData = new FormData();
    formData.append('idrol', idrol);

    axios.post(url + '/roles/borrar-global', formData, {})
        .then((response) => {
            closeLoading()
            $('#modalBorrar').modal('hide');

            if (response.data.success === 1) {
                toastr.success('Rol global eliminado');
                recargar();
            } else {
                toastr.error('Error al eliminar');
            }
        })
        .catch((error) => {
            closeLoading();
            toastr.error('Error al eliminar');
        });
}

function agregarRol() {
    var nombre = document.getElementById('nombre-nuevo').value;

    if (nombre === '') {
        toastr.error('Nombre es requerido')
        return;
    }

    if (nombre.length > 30) {
        toastr.error('Máximo 30 caracteres para Nombre')
        return;
    }

    openLoading()
    var formData = new FormData();
    formData.append('nombre', nombre);

    axios.post(url + '/permisos/nuevo-rol', formData, {})
        .then((response) => {
            closeLoading()

            if (response.data.success === 1) {
                toastr.error('Rol Repetido', 'Cambiar de nombre');
            } else if (response.data.success === 2) {
                $('#modalAgregar').modal('hide');
                recargar();
            } else {
                toastr.error('Error al guardar');
            }
        })
        .catch((error) => {
            closeLoading()
            toastr.error('Error al guardar');
        });
}

function recargar() {
    var ruta = "{{ url('/admin/roles/tabla') }}";
    $('#tablaDatatable').load(ruta);
}


// PARA ACTUALIZAR TABLA DE COSTOS
function actualizarTabla() {

    openLoading()

    axios.post(url + '/actualizartabla', {})
        .then((response) => {
            closeLoading()

            if (response.data.success === 1) {
                toastr.success('completado');
            } else {
                toastr.error('Error al guardar');
            }
        })
        .catch((error) => {
            closeLoading()
            toastr.error('Error al guardar');
        });
}
</script>



@stop