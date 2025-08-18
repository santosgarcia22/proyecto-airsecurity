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

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar Acceso Diamante</h4>
            </div>

            <form action="{{ route('admin.accesos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row g-3">
                        <!-- Sidebar -->
                        <div class="col-lg-3">
                            <div class="nav flex-lg-column nav-pills gap-2" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active" id="tab-base" data-bs-toggle="pill"
                                    data-bs-target="#panel-base" type="button" role="tab">1. Datos base</button>
                                <button class="nav-link" id="tab-op" data-bs-toggle="pill" data-bs-target="#panel-op"
                                    type="button" role="tab">2. Operativa</button>
                                <button class="nav-link" id="tab-tiempo" data-bs-toggle="pill"
                                    data-bs-target="#panel-tiempo" type="button" role="tab">3. Tiempos</button>
                                <button class="nav-link" id="tab-equipos" data-bs-toggle="pill"
                                    data-bs-target="#panel-equipos" type="button" role="tab">4. Equipos</button>
                                <button class="nav-link" id="tab-adj" data-bs-toggle="pill" data-bs-target="#panel-adj"
                                    type="button" role="tab">5. Adjuntos</button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="col-lg-9">
                            <div class="tab-content" id="v-pills-tabContent">

                                {{-- === 1. DATOS BASE (tus campos originales) === --}}
                                <div class="tab-pane fade show active" id="panel-base" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="tipo" class="form-label">Tipo</label>
                                            <select name="tipo" id="tipo" class="form-control" required>
                                                <option value="">Seleccione un tipo...</option>
                                                @foreach($Tipos as $tipo)
                                                <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre_tipo }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="posicion" class="form-label">Posición</label>
                                            <input type="text" name="posicion" id="posicion" class="form-control"
                                                required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="id" class="form-label">ID</label>
                                            <input type="text" name="id" id="id" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="ingreso" class="form-label">Ingreso (fecha y hora)</label>
                                            <input type="datetime-local" name="ingreso" id="ingreso"
                                                class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="salida" class="form-label">Salida (fecha y hora)</label>
                                            <input type="datetime-local" name="salida" id="salida" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Sicronizacion" class="form-label">Sincronización (fecha y
                                                hora)</label>
                                            <input type="datetime-local" name="Sicronizacion" id="Sicronizacion"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <label class="form-label">Empresa</label>
                                            <input type="text" name="empresa" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Motivo</label>
                                            <input type="text" name="motivo" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Fecha (operación)</label>
                                            <input type="date" name="fecha_operacion" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                {{-- === 2. OPERATIVA === --}}
                                <div class="tab-pane fade" id="panel-op" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-sm-3">
                                            <label class="form-label">Estación</label>
                                            <input type="text" name="estacion" class="form-control">
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Origen</label>
                                            <input type="text" name="origen" class="form-control">
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Matricula</label>
                                            <input type="text" name="destino" class="form-control">
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">COA</label>
                                            <input type="text" name="coa" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Líder / Super / Coor</label>
                                            <input type="text" name="lideres" class="form-control"
                                                placeholder="Separar por comas">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Agente/Oficial SEG</label>
                                            <input type="text" name="agente_seguridad_nombre" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">ID Agente/Oficial</label>
                                            <input type="text" name="agente_seguridad_id" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Equipo / Herramientas</label>
                                            <textarea name="equipo_herramientas" class="form-control"
                                                rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- === 3. TIEMPOS / ACTIVIDADES (compactado en tabla) === --}}
                                <div class="tab-pane fade" id="panel-tiempo" role="tabpanel">
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
                                                    <td>Aseo</td>
                                                    <td><input type="time" name="aseo_inicio" class="form-control"></td>
                                                    <td><input type="time" name="aseo_fin" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>Revisión Cabina</td>
                                                    <td><input type="time" name="rev_cabina_inicio"
                                                            class="form-control"></td>
                                                    <td><input type="time" name="rev_cabina_fin" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Catering</td>
                                                    <td><input type="time" name="catering_inicio" class="form-control">
                                                    </td>
                                                    <td><input type="time" name="catering_fin" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Abordaje</td>
                                                    <td><input type="time" name="abordaje_inicio" class="form-control">
                                                    </td>
                                                    <td><input type="time" name="abordaje_fin" class="form-control">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bodega 1</td>
                                                    <td><input type="time" name="bodega1_inicio" class="form-control">
                                                    </td>
                                                    <td><input type="time" name="bodega1_fin" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>Bodega 2</td>
                                                    <td><input type="time" name="bodega2_inicio" class="form-control">
                                                    </td>
                                                    <td><input type="time" name="bodega2_fin" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>Bulk</td>
                                                    <td><input type="time" name="bulk_apertura" class="form-control"
                                                            placeholder="Apertura"></td>
                                                    <td><input type="time" name="bulk_cierre" class="form-control"
                                                            placeholder="Cierre"></td>
                                                </tr>
                                                <tr>
                                                    <td>Bodegas (general)</td>
                                                    <td><input type="time" name="bodegas_apertura" class="form-control"
                                                            placeholder="Apertura"></td>
                                                    <td><input type="time" name="bodegas_cierre" class="form-control"
                                                            placeholder="Cierre"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-sm-4">
                                            <label class="form-label">Hora ingreso auxiliares/Tripulación</label>
                                            <input type="time" name="ingreso_aux_tripulacion" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">Cierre de puertas</label>
                                            <input type="time" name="cierre_puertas_hora" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">N.º Vehículo Catering</label>
                                            <input type="text" name="vehiculo_catering_num" class="form-control">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">Precinto Catering</label>
                                            <input type="text" name="precinto_catering" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                {{-- === 4. EQUIPOS (repetible dinámico) === --}}
                                <div class="tab-pane fade" id="panel-equipos" role="tabpanel">
                                    <div id="equiposContainer" class="vstack gap-3">
                                        <!-- fila inicial -->
                                        <div class="row g-2 align-items-end equipo-item" data-index="0">
                                            <div class="col-sm-4">
                                                <label class="form-label">Equipo N.º</label>
                                                <input type="text" name="equipos[0][numero]" class="form-control">
                                            </div>
                                            <div class="col-sm-7">
                                                <label class="form-label">Motivo</label>
                                                <input type="text" name="equipos[0][motivo]" class="form-control">
                                            </div>
                                            <div class="col-sm-1 d-grid">
                                                <button type="button" class="btn btn-outline-danger btn-remove"
                                                    disabled>&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" id="btnAddEquipo" class="btn btn-outline-primary">Agregar
                                            equipo</button>
                                        <small class="text-muted ms-2">Máximo 9 filas.</small>
                                    </div>
                                </div>

                                {{-- === 5. ADJUNTOS === --}}
                                <div class="tab-pane fade" id="panel-adj" role="tabpanel">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="objetos" class="form-label">Foto (objetos)</label>
                                            <input type="file" name="objetos" id="objetos" class="form-control"
                                                accept="image/png, image/jpeg, image/jpg, image/webp, image/bmp, image/tiff, image/heic"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Firma (general)</label>
                                            <input type="file" name="firma" class="form-control"
                                                accept="image/png, image/jpeg, image/webp, image/heic">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Firma Agente/Oficial</label>
                                            <input type="file" name="agente_seguridad_firma" class="form-control"
                                                accept="image/png, image/jpeg, image/webp, image/heic">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- /content -->
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center sticky-actions">
                    <small class="text-muted">Revisa cada pestaña antes de guardar.</small>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.accesos.show') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS + script equipos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function() {
        const container = document.getElementById('equiposContainer');
        const btnAdd = document.getElementById('btnAddEquipo');
        const maxRows = 9;

        btnAdd.addEventListener('click', () => {
            const rows = container.querySelectorAll('.equipo-item').length;
            if (rows >= maxRows) return;

            const idx = rows;
            const row = document.createElement('div');
            row.className = 'row g-2 align-items-end equipo-item';
            row.dataset.index = idx;
            row.innerHTML = `
                    <div class="col-sm-4">
                        <label class="form-label">Equipo N.º</label>
                        <input type="text" name="equipos[${idx}][numero]" class="form-control">
                    </div>
                    <div class="col-sm-7">
                        <label class="form-label">Motivo</label>
                        <input type="text" name="equipos[${idx}][motivo]" class="form-control">
                    </div>
                    <div class="col-sm-1 d-grid">
                        <button type="button" class="btn btn-outline-danger btn-remove">&times;</button>
                    </div>
                `;
            container.appendChild(row);
            updateRemoveButtons();
        });

        container.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-remove')) {
                e.target.closest('.equipo-item').remove();
                // reindexar
                [...container.querySelectorAll('.equipo-item')].forEach((row, i) => {
                    row.dataset.index = i;
                    row.querySelectorAll('input').forEach(input => {
                        if (input.name.includes('[numero]')) input.name =
                            `equipos[${i}][numero]`;
                        if (input.name.includes('[motivo]')) input.name =
                            `equipos[${i}][motivo]`;
                    });
                });
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const rows = container.querySelectorAll('.equipo-item');
            rows.forEach((r, i) => {
                const btn = r.querySelector('.btn-remove');
                btn.disabled = (rows.length === 1);
            });
        }
    })();
    </script>
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