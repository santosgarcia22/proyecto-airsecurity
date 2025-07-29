@extends('backend.menus.superior')

@section('content-admin-css')
<!-- Estilos DataTables y Toastr desde CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@stop

<style>
.card-success>.card-header {
    background: rgb(57, 155, 255) !important;
    color: white !important;
    border-radius: 8px 8px 0 0;
}

.table td,
.table th {
    vertical-align: middle;
    text-align: center;
}
</style>

<div class="container-fluid">
    <h3 class="mt-3">Usuarios App</h3>

    <button onclick="modalAgregarApp()" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle"></i> Nuevo Usuario
    </button>

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Listado de Usuarios</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            @endif

            <table id="tablaUsuariosApp" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Nombre Completo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
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
                            <span class="badge {{ $item->activo ? 'badge-success' : 'badge-danger' }}">
                                {{ $item->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" data-toggle="modal"
                                data-target="#modalEditar{{ $item->id_usuario }}">Editar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Agregar --}}
<div class="modal fade" id="modalAgregarApp">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.usuariosapp.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre_completo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modales Editar --}}
@foreach($usuarios as $item)
<div class="modal fade" id="modalEditar{{ $item->id_usuario }}">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.usuariosapp.update', $item->id_usuario) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre_completo" class="form-control"
                            value="{{ $item->nombre_completo }}" required>
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" name="usuario" class="form-control" value="{{ $item->usuario }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $item->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Dejar en blanco si no cambia">
                    </div>
                    <div class="form-group">
                        <label>Activo</label><br>
                        <input type="checkbox" name="activo" value="1" {{ $item->activo ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@extends('backend.menus.footerjs')
@section('archivos-js')
<!-- Scripts desde CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
function modalAgregarApp() {
    $('#modalAgregarApp').modal('show');
}

$(document).ready(function() {
    $('#tablaUsuariosApp').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
        },
        pageLength: 10,
        order: [
            [0, 'desc']
        ]
    });
});
</script>
@stop