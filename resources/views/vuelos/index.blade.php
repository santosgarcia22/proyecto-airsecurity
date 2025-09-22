@extends('backend.menus.superior')

<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />

<style>
/* ===== Layout / básicos (igual al de Personas) ===== */
.content-wrapper {
    padding-top: 1rem;
}

.page-container {
    padding: 0 20px 20px;
}

/* Título y botones */
.btn-hero {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1rem;
    border-radius: .75rem;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
}

.btn-hero+.btn-hero {
    margin-left: .75rem;
}

/* Barra “Lista” */
.section-bar {
    background: #3da2ff;
    color: #fff;
    border-radius: .5rem;
    padding: .85rem 1rem;
    font-weight: 600;
    margin: 1rem 0;
    box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
}

/* Card y tabla */
.card {
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, .15);
    overflow: hidden;
}

.table thead th {
    background: #0d6efd !important;
    color: #fff !important;
    text-align: center;
    font-size: 14px;
    letter-spacing: .3px;
}

.table tbody td {
    vertical-align: middle;
    font-size: 14px;
}

/* Acciones */
.btn-group-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    justify-content: center;
}

/* Loaders (mismo azul que Personas) */
.loader {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 0;
}

.spinner {
    border: 4px solid #e9f2ff;
    border-top: 4px solid #0d6efd;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg)
    }
}

/* Skeleton azul en carga parcial tabla */
.skeleton-row {
    height: 40px;
    border-radius: 4px;
    margin-bottom: 6px;
    background: linear-gradient(90deg, #e8f1ff 25%, #d7e7ff 50%, #e8f1ff 75%);
    background-size: 400% 100%;
    animation: shimmer 1.2s infinite;
}

@keyframes shimmer {
    0% {
        background-position: -400px 0
    }

    100% {
        background-position: 400px 0
    }
}

/* Responsivo */
@media (max-width: 991.98px) {
    .btn-hero {
        width: 100%;
        justify-content: center;
        margin-bottom: .5rem;
    }

    .btn-hero+.btn-hero {
        margin-left: 0;
    }
}

/* Loader (mismo estilo que las otras vistas) */
.loader {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 0;
}

.spinner {
    border: 4px solid #f3f3f3;
    /* gris claro */
    border-top: 4px solid #0d6efd;
    /* azul */
    border-radius: 50%;
    width: 35px;
    height: 35px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% {
        transform: rotate(360deg);
    }
}

/* Acciones responsivas de los botones de opciones */
.btn-opts {
    display: inline-flex;
    gap: .35rem;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.btn-opts .btn {
    padding-inline: .65rem;
}

/* Por defecto oculto el texto */
.btn-text {
    display: none;
}

/* A partir de XL (≥1200px) muestro el texto */
@media (min-width:1200px) {
    .btn-text {
        display: inline;
    }
}

/* Barra Lista pegada al card */
.section-bar {
    background: #3da2ff;
    color: #fff;
    border-radius: .5rem .5rem 0 0;
    /* redondeo solo arriba */
    padding: .85rem 1rem;
    font-weight: 600;
    margin-bottom: 0;
    /* 👈 sin separación */
    box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
}

/* El card justo debajo sin radio arriba para que unan perfecto */
.card.after-section {
    border-radius: 0 0 .75rem .75rem;
    /* radio solo abajo */
    margin-top: 0;
}

/* estilo para los filtros de ordenamiento */
.table thead th {
    background: #0d6efd !important;
    color: #fff !important;
    text-align: center;
    font-size: 14px;
    cursor: pointer;
    position: relative;
    user-select: none;
}

.table thead th .sort-icon {
    margin-left: 6px;
    display: inline-block;
    width: 10px;
}

.table thead th .sort-icon::before {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    content: "\f0dc";
    /* fa-sort */
    font-size: 12px;
    opacity: .6;
}

.table thead th.active.asc .sort-icon::before {
    content: "\f0de";
    /* fa-sort-up */
    opacity: 1;
}

.table thead th.active.desc .sort-icon::before {
    content: "\f0dd";
    /* fa-sort-down */
    opacity: 1;
}



.loader {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 0;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #0d6efd;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% {
        transform: rotate(360deg);
    }
}
</style>

<!-- Loader global -->
<div id="loaderGlobal" class="loader" style="position:fixed;top:0;left:0;width:100%;height:100%;
background:white;z-index:9999;display:flex;align-items:center;justify-content:center">
    <div class="spinner"></div>
</div>


<div class="page-container">
    <h1 class="mb-3">Vuelos</h1>

    <!-- Botones superiores con estilo hero -->
    <div class="mb-3">
        <a href="{{ route('admin.vuelo.create') }}" class="btn btn-primary btn-hero">
            <i class="fas fa-plane-departure"></i> Nuevo vuelo
        </a>
        <button type="button" id="modal" class="btn btn-primary btn-hero" data-toggle="modal"
            data-target="#modalOperadores">
            <i class="fas fa-users-cog"></i> Administrar Operadores
        </button>
    </div>

    <!-- Barra “Lista” -->
    <div class="section-bar">Lista</div>

    <div class="card shadow-sm after-section">
        <div class="card-body">

            <!-- Filtros (se mantienen) -->
            <form id="formFiltros" class="row mb-3">
                <div class="col-md-2 col-6 mb-2">
                    <label>Desde</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-2 col-6 mb-2">
                    <label>Hasta</label>
                    <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-md-4 col-12 mb-2">
                    <label>Buscar</label>
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Buscar..."
                            value="{{ request('q') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12 d-flex align-items-end justify-content-end"></div>
            </form>

            <!-- Tabla vuelos (carga parcial con shimmer azul) -->
            <div id="tablaVuelos">
                <div class="loader" id="loaderVuelos" style="display:none">
                    <div class="spinner"></div>
                </div>

                <div id="tablaContenido">
                    @include('vuelos.partials.tabla', ['vuelos' => $vuelos])
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ======= MODAL (sin cambios de lógica) ======= -->
<div class="modal fade" id="modalOperadores" tabindex="-1" aria-labelledby="modalOperadoresLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalOperadoresLabel">Operadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formOperador" action="{{ route('admin.operador.store') }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    <div class="col-md-3">
                        <input type="text" name="codigo" class="form-control" placeholder="Código" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre operador" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success w-100">Agregar</button>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="tablaOperadores">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th style="width:100px">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Operador::orderBy('nombre')->get() as $op)
                            <tr data-id="{{ $op->id }}">
                                <td>{{ $op->codigo }}</td>
                                <td>{{ $op->nombre }}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm btn-eliminar"
                                        data-url="{{ route('admin.operador.destroy', $op->id) }}"
                                        data-token="{{ csrf_token() }}">
                                        Eliminar
                                    </button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ======= SCRIPTS (tu misma lógica) ======= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/delete.js') }}"></script>

<script>
$(function() {
    function cargarTabla(url, datos = {}) {
        $('#tablaContenido').hide();
        $('#loaderVuelos').fadeIn(200);

        $.get(url, datos, function(data) {
            let contenido = $(data).find('#tablaContenido').html();
            $('#tablaContenido').html(contenido);

            $('#loaderVuelos').fadeOut(200, function() {
                $('#tablaContenido').fadeIn(300);
            });
        });
    }

    $('#tablaContenido').fadeIn(200);

    $('#formFiltros').on('submit', function(e) {
        e.preventDefault();
        let datos = $(this).serialize();
        cargarTabla("{{ route('admin.vuelo.index') }}", datos);
    });

    $(document).on('click', '#tablaContenido .pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        cargarTabla(url);
    });
});
</script>

<script>
$(window).on('load', function() {
    $('#loaderGlobal').fadeOut(300);
    $('#tablaContenido').fadeIn(300);
});
</script>

<script>
$(document).on('click', 'th[data-col]', function() {
    let col = $(this).data('col');
    let currentDir = $(this).attr('data-dir') || 'asc';
    let newDir = currentDir === 'asc' ? 'desc' : 'asc';

    // Reset
    $('th[data-col]').removeClass('active asc desc').removeAttr('data-dir');

    // Activar en la columna clicada
    $(this).addClass('active ' + newDir).attr('data-dir', newDir);

    // Recargar tabla vía AJAX con sort + direction
    let datos = $('#formFiltros').serialize() + '&sort=' + col + '&direction=' + newDir;
    cargarTabla("{{ route('admin.vuelo.index') }}", datos);
});
</script>

<script>
$(function() {
    // 🚀 AJAX para crear operador sin recargar
    $('#formOperador').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let datos = form.serialize();

        $.post(url, datos)
            .done(function(res) {
                // Agregar la nueva fila a la tabla
                $('#tablaOperadores tbody').append(`
                    <tr data-id="${res.id}">
                        <td>${res.codigo}</td>
                        <td>${res.nombre}</td>
                        <td class="text-center">
                               <button class="btn btn-danger btn-sm btn-eliminar"
                                    data-url="/admin/operadores/${res.id}"
                                    data-token="{{ csrf_token() }}">
                                    Eliminar
                                </button>
                        </td>
                    </tr>
                `);

                // limpiar inputs para seguir agregando
                form.trigger('reset');
            })
            .fail(function(xhr) {
                alert('Error al agregar operador');
                console.log(xhr.responseText);
            });
    });
});
</script>