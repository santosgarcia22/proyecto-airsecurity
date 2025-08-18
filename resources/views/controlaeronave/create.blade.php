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

    <style>
    .sticky-actions {
        position: sticky;
        bottom: 0;
        background: #fff;
        border-top: 1px solid #e9ecef;
        padding: .75rem;
        z-index: 10
    }

    .nav-pills .nav-link {
        border-radius: .5rem
    }

    .tab-pane {
        padding-top: .5rem
    }
    </style>

    <style>
    table {
        table-layout: fixed
    }

    .sticky-actions {
        position: sticky;
        bottom: 0;
        background: #fff;
        border-top: 1px solid #e9ecef;
        padding: .75rem;
        z-index: 10
    }

    .nav-pills .nav-link {
        border-radius: .5rem
    }

    .tab-pane {
        padding-top: .5rem
    }
    </style>

    <div id="divcontenedor">

        <div class="container mt-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Control acceso aeronave - Crear</h4>
                </div>

                <form action="{{ route('admin.controlaeronave.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Tabs -->
                            <div class="col-lg-3">
                                <div class="nav flex-lg-column nav-pills gap-2" role="tablist">
                                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-base"
                                        type="button">1. Datos base</button>
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-procesos"
                                        type="button">2. Procesos / tiempos</button>
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-demoras"
                                        type="button">3. Demoras y pax</button>
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-seg"
                                        type="button">4. Seguridad / adjuntos</button>
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-acce"
                                        type="button">5. Datos de accesos</button>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="col-lg-9">
                                <div class="tab-content">

                                    {{-- 1 DATOS BASE --}}
                                    <div class="tab-pane fade show active" id="tab-base">
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <label class="form-label">Fecha</label>
                                                <input type="date" name="fecha" class="form-control" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Origen</label>
                                                <input type="text" name="origen" class="form-control" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">N.º de vuelo (origen)</label>
                                                <input type="text" name="numero_vuelo" class="form-control" required>
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="form-label">Hora de llegada</label>
                                                <input type="time" name="hora_llegada" class="form-control" required>
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="form-label">Posición de llegada</label>
                                                <input type="text" name="posicion_llegada" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Matrícula y operador (TAI, LRC, AV GUG,
                                                    ...)</label>
                                                <input type="text" name="matricula_operador" class="form-control"
                                                    required placeholder="Ej.: N123AB / AV GUG">
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">Coordinador / Líder de vuelo</label>
                                                <input type="text" name="coordinador_lider" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 2 PROCESOS / TIEMPOS --}}
                                    <div class="tab-pane fade" id="tab-procesos">
                                        <div class="table-responsive">
                                            <table class="table table-sm align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Actividad</th>
                                                        <th style="width:180px">Inicio</th>
                                                        <th style="width:180px">Fin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Desabordaje</td>
                                                        <td><input type="time" name="desabordaje_inicio"
                                                                class="form-control" required></td>
                                                        <td><input type="time" name="desabordaje_fin"
                                                                class="form-control" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Inspección cabina</td>
                                                        <td><input type="time" name="inspeccion_cabina_inicio"
                                                                class="form-control" required></td>
                                                        <td><input type="time" name="inspeccion_cabina_fin"
                                                                class="form-control" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Aseo (personal)</td>
                                                        <td><input type="time" name="aseo_ingreso" class="form-control"
                                                                required placeholder="Ingreso"></td>
                                                        <td><input type="time" name="aseo_salida" class="form-control"
                                                                required placeholder="Salida"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tripulación</td>
                                                        <td><input type="time" name="tripulacion_ingreso"
                                                                class="form-control" required placeholder="Ingreso">
                                                        </td>
                                                        <td><input type="time" name="salida_itinerario"
                                                                class="form-control" required
                                                                placeholder="Salida itinerario"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Abordaje</td>
                                                        <td><input type="time" name="abordaje_inicio"
                                                                class="form-control" required></td>
                                                        <td><input type="time" name="abordaje_fin" class="form-control"
                                                                required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cierre de puertas</td>
                                                        <td><input type="time" name="cierre_puertas"
                                                                class="form-control" required></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- 3 DEMORAS Y PAX --}}
                                    <div class="tab-pane fade" id="tab-demoras">
                                        <div class="row g-3">
                                            <div class="col-sm-3">
                                                <label class="form-label">Tiempo (min)</label>
                                                <input type="number" min="0" name="demora_tiempo" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col-sm-9">
                                                <label class="form-label">Motivo de demora</label>
                                                <input type="text" name="demora_motivo" class="form-control" required>
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="form-label">Destino</label>
                                                <input type="text" name="destino" class="form-control" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">N.º de vuelo (destino)</label>
                                                <input type="text" name="numero_vuelo_destino" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Total pax</label>
                                                <input type="number" min="0" name="total_pax" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Hora real de salida</label>
                                                <input type="time" name="hora_real_salida" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 4 SEGURIDAD / ADJUNTOS --}}
                                    <div class="tab-pane fade" id="tab-seg">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Agente/Oficial de seguridad (nombre)</label>
                                                <input type="text" name="agente_nombre" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ID Agente/Oficial</label>
                                                <input type="text" name="agente_id" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Firma Agente/Oficial</label>
                                                <input type="file" name="agente_firma" class="form-control"
                                                    accept="image/png,image/jpeg,image/webp,image/heic">
                                            </div>
                                        </div>
                                    </div>


                                    {{-- 5 Datos de acceso --}}
                                    <div class="tab-pane fade" id="tab-acce">
                                        <div class="row g-3">
                                            <!-- Fila 1 -->
                                            <div class="col-md-4">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" name="nombre" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">ID</label>
                                                <input type="text" name="id" class="form-control" required>
                                            </div>

                                            <!-- Fila 2 -->
                                            <div class="col-md-3">
                                                <label class="form-label">Hora Entrada</label>
                                                <input type="time" name="hora_entrada" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Hora Salida</label>
                                                <input type="time" name="hora_salida" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Hora Entrada 2</label>
                                                <input type="time" name="hora_entrada1" class="form-control" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Hora Salida 2</label>
                                                <input type="time" name="hora_salida1" class="form-control" required>
                                            </div>

                                            <!-- Fila 3 -->
                                            <div class="col-md-6">
                                                <label class="form-label">Herramientas</label>
                                                <input type="text" name="herramientas" class="form-control" required
                                                    placeholder="Desarmador">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Empresa y Área</label>
                                                <input type="text" name="empresa" class="form-control" required>
                                            </div>

                                            <!-- Fila 4 -->
                                            <div class="col-12">
                                                <label class="form-label">Motivo Entrada</label>
                                                <textarea name="motivo" class="form-control"
                                                    rows="1"></textarea>
                                            </div>

                                            <!-- Fila 5 -->
                                            <div class="col-md-4">
                                                <label class="form-label">Firma Agente/Oficial</label>
                                                <input type="file" name="firma" class="form-control"
                                                    accept="image/png,image/jpeg,image/webp,image/heic">
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- /content -->
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center sticky-actions">
                            <small class="text-muted">Revisa cada pestaña antes de guardar.</small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.controlaeronave.show') }}"
                                    class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    </div>

    @extends('backend.menus.footerjs')
    @section('archivos-js')
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('divcontenedor').style.display = 'block';
    });
    </script>
    @stop



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