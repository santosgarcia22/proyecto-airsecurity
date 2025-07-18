@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/responsive.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/buttons.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
table {
    table-layout: fixed;
}

.card-success>.card-header {
    background: rgb(57, 155, 255) !important;
    color: #fff !important;
    border-radius: 8px 8px 0 0;
}
</style>





<div id="divcontenedor">
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-sm-12">
                <h1>Usuarios App</h1>
            </div>
            <br>
            <button type="button"
                style="font-weight: bold; background-color:rgb(52, 131, 222); color: white !important;"
                onclick="modalAgregarApp()" class="button button-3d button-rounded button-pill button-small">
                <i class="fas fa-pencil-alt"></i>
                Nuevo Usuario App
            </button>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Lista</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Nombre Completo</th>
                                            <th>Activo</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usuarios as $item)
                                        <tr>
                                            <td>{{ $item->id_usuario }}</td>
                                            <td>{{ $item->usuario }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->nombre_completo }}</td>
                                            <td>
                                                @if($item->activo)
                                                <span class="badge badge-success">Activo</span>
                                                @else
                                                <span class="badge badge-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button
                                                    onclick="verInfoUsuarioApp({{ $item->id_usuario }})">Editar</button>

                                            </td>
                                        </tr>
                                        @endforeach

                                        @if(count($usuarios) == 0)
                                        <tr>
                                            <td colspan="6" class="text-center">No hay registros</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {!! $usuarios->links('pagination::bootstrap-4') !!}
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Agregar --}}
    <div class="modal fade" id="modalAgregarApp">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Usuario App</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-nuevoapp">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Nombre Completo</label>
                                        <input type="text" maxlength="100" autocomplete="off" class="form-control"
                                            id="nombreapp-nuevo" name="nombre_completo" placeholder="Nombre completo">
                                    </div>

                                    <div class="form-group">
                                        <label>Usuario</label>
                                        <input type="text" maxlength="50" autocomplete="off" class="form-control"
                                            id="usuarioapp-nuevo" name="usuario" placeholder="Usuario">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" maxlength="100" autocomplete="off" class="form-control"
                                            id="emailapp-nuevo" name="email" placeholder="Email">
                                    </div>

                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <input type="password" maxlength="16" autocomplete="off" class="form-control"
                                            id="passwordapp-nuevo" name="password" placeholder="Contraseña">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;"
                        class="button button-3d button-rounded button-pill button-small"
                        onclick="nuevoUsuarioApp()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Editar --}}
    <div class="modal fade" id="modalEditarApp">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Usuario App</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-editarapp">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <input type="hidden" id="idapp-editar">

                                    <div class="form-group">
                                        <label>Nombre Completo</label>
                                        <input type="text" maxlength="100" autocomplete="off" class="form-control"
                                            id="nombreapp-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Usuario</label>
                                        <input type="text" maxlength="50" autocomplete="off" class="form-control"
                                            id="usuarioapp-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" maxlength="100" autocomplete="off" class="form-control"
                                            id="emailapp-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <input type="password" maxlength="16" autocomplete="off" class="form-control"
                                            id="passwordapp-editar"
                                            placeholder="Contraseña (dejar vacío para no cambiar)">
                                    </div>

                                    <div class="form-group">
                                        <label>Disponibilidad</label><br>
                                        <label class="switch" style="margin-top:10px">
                                            <input type="checkbox" id="toggleapp-editar">
                                            <div class="slider round">
                                                <span class="on">Activo</span>
                                                <span class="off">Inactivo</span>
                                            </div>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;"
                        class="button button-3d button-rounded button-pill button-small"
                        onclick="actualizarUsuarioApp()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('archivos-js')

<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
$(document).ready(function() {
    var ruta = "{{ url('admin/usuariosapp/tabla') }}";
    // $('#tablaDatatable').load(ruta); // ✅ este ID sí existe
});


function recargarApp() {
    var ruta = "{{ url('admin/usuariosapp/tabla') }}";
    location.reload(); // ✅
}



function modalAgregarApp() {
    document.getElementById("formulario-nuevoapp").reset();
    $('#modalAgregarApp').modal('show');
}

function nuevoUsuarioApp() {
    var nombre = document.getElementById('nombreapp-nuevo').value;
    var usuario = document.getElementById('usuarioapp-nuevo').value;
    var email = document.getElementById('emailapp-nuevo').value;
    var password = document.getElementById('passwordapp-nuevo').value;

    if (nombre === '' || usuario === '' || email === '' || password === '') {
        toastr.error('Todos los campos son obligatorios');
        return;
    }

    openLoading();
    var formData = new FormData();
    formData.append('nombre_completo', nombre);
    formData.append('usuario', usuario);
    formData.append('email', email);
    formData.append('password', password);

    axios.post("{{ url('/admin/usuariosapp/nuevo') }}", formData)
        .then((response) => {
            closeLoading();
            if (response.data.success === 1) {
                toastr.error('El usuario o email ya existe');
            } else if (response.data.success === 2) {
                toastr.success('Agregado');
                $('#modalAgregarApp').modal('hide');
                recargarApp();
            } else {
                toastr.error('Error al guardar');
            }
        })
        .catch((error) => {
            closeLoading();
            toastr.error('Error al guardar');
        });
}

function verInfoUsuarioApp(id) {
    openLoading();
    document.getElementById("formulario-editarapp").reset();
    axios.post("{{ url('/admin/usuariosapp/info') }}", {
            id: id
        })
        .then((response) => {
            closeLoading();
            if (response.data.success === 1) {
                $('#modalEditarApp').modal('show');
                $('#idapp-editar').val(response.data.usuario.id_usuario);
                $('#nombreapp-editar').val(response.data.usuario.nombre_completo);
                $('#usuarioapp-editar').val(response.data.usuario.usuario);
                $('#emailapp-editar').val(response.data.usuario.email);

                $("#toggleapp-editar").prop("checked", response.data.usuario.activo === 1);
            } else {
                toastr.error('No encontrado');
            }
        })
        .catch((error) => {
            closeLoading();
            toastr.error('No encontrado');
        });
}

function actualizarUsuarioApp() {
    var id = document.getElementById('idapp-editar').value;
    var nombre = document.getElementById('nombreapp-editar').value;
    var usuario = document.getElementById('usuarioapp-editar').value;
    var email = document.getElementById('emailapp-editar').value;
    var password = document.getElementById('passwordapp-editar').value;
    var activo = document.getElementById('toggleapp-editar').checked ? 1 : 0;

    if (nombre === '' || usuario === '' || email === '') {
        toastr.error('Nombre, usuario y email son obligatorios');
        return;
    }

    openLoading();
    var formData = new FormData();
    formData.append('id_usuario', id);
    formData.append('nombre_completo', nombre);
    formData.append('usuario', usuario);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('activo', activo);

    axios.post("{{ url('/admin/usuariosapp/editar') }}", formData)
        .then((response) => {
            closeLoading();
            if (response.data.success === 1) {
                toastr.error('El usuario o email ya existe');
            } else if (response.data.success === 2) {
                toastr.success('Actualizado');
                $('#modalEditarApp').modal('hide');
                recargarApp();
            } else {
                toastr.error('Error al actualizar');
            }
        })
        .catch((error) => {
            closeLoading();
            toastr.error('Error al actualizar');
        });
}
</script>
@stop

@section('archivos-js')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function () {
    $('.table').DataTable({
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    });
});

function showLoading() {
    $('body').append('<div id="loading-overlay"><div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando...</span></div></div>');
}
function hideLoading() {
    $('#loading-overlay').remove();
}

function modalAgregarApp() {
    document.getElementById("formulario-nuevoapp").reset();
    $('#modalAgregarApp').modal('show');
}

function nuevoUsuarioApp() {
    let nombre = $('#nombreapp-nuevo').val();
    let usuario = $('#usuarioapp-nuevo').val();
    let email = $('#emailapp-nuevo').val();
    let password = $('#passwordapp-nuevo').val();

    if (!nombre || !usuario || !email || !password) {
        toastr.error('Todos los campos son obligatorios');
        return;
    }

    showLoading();

    axios.post("{{ url('/admin/usuariosapp/nuevo') }}", {
        nombre_completo: nombre,
        usuario: usuario,
        email: email,
        password: password
    }).then(response => {
        hideLoading();
        if (response.data.success === 2) {
            toastr.success('Usuario agregado correctamente');
            $('#modalAgregarApp').modal('hide');
            location.reload();
        } else {
            toastr.error('El usuario o email ya existe');
        }
    }).catch(() => {
        hideLoading();
        toastr.error('Error al guardar');
    });
}

function verInfoUsuarioApp(id) {
    showLoading();
    axios.post("{{ url('/admin/usuariosapp/info') }}", { id: id })
        .then(response => {
            hideLoading();
            if (response.data.success === 1) {
                $('#modalEditarApp').modal('show');
                $('#idapp-editar').val(response.data.usuario.id_usuario);
                $('#nombreapp-editar').val(response.data.usuario.nombre_completo);
                $('#usuarioapp-editar').val(response.data.usuario.usuario);
                $('#emailapp-editar').val(response.data.usuario.email);
                $('#toggleapp-editar').prop("checked", response.data.usuario.activo === 1);
            } else {
                toastr.error('Usuario no encontrado');
            }
        }).catch(() => {
            hideLoading();
            toastr.error('Error al obtener datos');
        });
}

function actualizarUsuarioApp() {
    let id = $('#idapp-editar').val();
    let nombre = $('#nombreapp-editar').val();
    let usuario = $('#usuarioapp-editar').val();
    let email = $('#emailapp-editar').val();
    let password = $('#passwordapp-editar').val();
    let activo = $('#toggleapp-editar').is(':checked') ? 1 : 0;

    if (!nombre || !usuario || !email) {
        toastr.error('Nombre, usuario y email son obligatorios');
        return;
    }

    showLoading();

    axios.post("{{ url('/admin/usuariosapp/editar') }}", {
        id_usuario: id,
        nombre_completo: nombre,
        usuario: usuario,
        email: email,a@extends('adminlte::page')

@section('title', 'Usuarios App')

@section('content_header')
    <h1>Usuarios App</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalNuevo">+ Nuevo Usuario</button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Usuario</th><th>Email</th><th>Nombre Completo</th><th>Activo</th><th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $u)
                <tr>
                    <td>{{ $u->id_usuario }}</td>
                    <td>{{ $u->usuario }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->nombre_completo }}</td>
                    <td>
                        @if($u->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editarUsuario({{ $u->id_usuario }})">Editar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1">
        <div class="modal-dialog">
            <form id="formUsuario" method="POST" action="{{ route('admin.usuariosapp.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header"><h5 class="modal-title">Nuevo Usuario App</h5></div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre_completo" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Usuario</label>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group mb-2">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
function editarUsuario(id) {
    fetch('/admin/usuariosapp/' + id)
        .then(res => res.json())
        .then(data => {
            const form = document.getElementById('formUsuario');
            form.action = '/admin/usuariosapp/' + id;
            form.querySelector('input[name="nombre_completo"]').value = data.nombre_completo;
            form.querySelector('input[name="usuario"]').value = data.usuario;
            form.querySelector('input[name="email"]').value = data.email;
            form.querySelector('input[name="password"]').value = ''; // no mostrar
            const method = document.createElement('input');
            method.setAttribute('type', 'hidden');
            method.setAttribute('name', '_method');
            method.setAttribute('value', 'PUT');
            form.appendChild(method);
            new bootstrap.Modal(document.getElementById('modalNuevo')).show();
        });
}
</script>
@endsection

        password: password,
        activo: activo
    }).then(response => {
        hideLoading();
        if (response.data.success === 2) {
            toastr.success('Usuario actualizado');
            $('#modalEditarApp').modal('hide');
            location.reload();
        } else {
            toastr.error('El usuario o email ya existe');
        }
    }).catch(() => {
        hideLoading();
        toastr.error('Error al actualizar');
    });
}
</script>
@stop
