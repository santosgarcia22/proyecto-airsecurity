@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
<style>
/* ===== Layout / básicos (igual al de Roles & Permisos) ===== */
.content-wrapper {
    padding-top: 1rem;
}

.btn-hero {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1rem;
    border-radius: .75rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
    font-weight: 600;
}

.btn-hero+.btn-hero {
    margin-left: .75rem;
}

.section-bar {
    background: #3da2ff;
    color: #fff;
    border-radius: .5rem;
    padding: .85rem 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
}

/* DataTables: mover length (l) a la izq y search (f) a la der */
div.dataTables_wrapper .row>div[class^="col-"] {
    display: flex;
    align-items: center;
}

div.dataTables_wrapper .dataTables_length select {
    margin: 0 .5rem;
}

/* Botonera opciones */
.btn-opts {
    display: inline-flex;
    gap: .35rem;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.btn-opts .btn {
    padding-inline: .65rem;
}

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

/* === Spinner azul (loaderGlobal) === */
.spinner {
    border: 4px solid #e9f2ff;
    /* borde claro */
    border-top: 4px solid #0d6efd;
    /* azul */
    border-radius: 50%;
    width: 38px;
    height: 38px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg)
    }
}

/* === Skeleton azul (loaderVuelos) === */
.skeleton-row {
    height: 40px;
    background: linear-gradient(90deg,
            #e8f1ff 25%,
            /* azul muy claro */
            #d7e7ff 50%,
            /* azul claro para el destello */
            #e8f1ff 75%);
    background-size: 400% 100%;
    animation: shimmer 1.2s infinite;
    border-radius: 4px;
    margin-bottom: 6px;
}

@keyframes shimmer {
    0% {
        background-position: -400px 0;
    }

    100% {
        background-position: 400px 0;
    }
}
</style>
@stop

<div id="loaderGlobal" class="loader" style="position:fixed;top:0;left:0;width:100%;height:100%;
background:white;z-index:9999;display:flex;align-items:center;justify-content:center">
    <div class="spinner"></div>
</div>


<div class="container-fluid">

    <h1 class="mb-3">Personas</h1>

    <div class="mb-3">
        <a href="{{ route('admin.personas.create') }}" class="btn btn-primary btn-hero">
            <i class="fas fa-plus"></i> Nueva Persona
        </a>
        <a href="{{ route('admin.personas.index') }}" class="btn btn-primary btn-hero">
            <i class="fas fa-list"></i> Lista de Personas
        </a>
    </div>


    <div id="tablaVuelos">
        <div id="loaderVuelos" style="display:none">
            <div class="skeleton-row"></div>
            <div class="skeleton-row"></div>
            <div class="skeleton-row"></div>
        </div>
        <div class="section-bar">Lista</div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div id="tablaContenido">
                    <table class="table table-bordered table-hover" id="tablaPersonas" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Identificación</th>
                                <th>Empresa</th>
                                <th>Rol</th>
                                <th class="text-right">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personas as $persona)
                            <tr>
                                <td>{{ $persona->id }}</td>
                                <td>{{ $persona->nombre }}</td>
                                <td>{{ $persona->identificacion }}</td>
                                <td>{{ $persona->empresa }}</td>
                                <td>{{ $persona->rol }}</td>
                                <td class="text-right">
                                    <div class="btn-opts">
                                        <a href="{{ route('admin.personas.edit', $persona->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-pen"></i> <span class="d-none d-xl-inline">Editar</span>
                                        </a>
                                        <button class="btn btn-danger btn-sm btn-eliminar"
                                            data-url="{{ route('admin.personas.destroy', $persona->id) }}"
                                            data-token="{{ csrf_token() }}">
                                            <i class="fas fa-trash"></i> <span
                                                class="d-none d-xl-inline">Eliminar</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Paginación Laravel (mantiene filtros) --}}
                    <div class="mt-3">
                        {{ $personas->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@extends('backend.menus.footerjs')
@section('archivos-js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script>
$(function() {
    // ✅ Mostrar loader antes de cargar tabla
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

    // ✅ Primera carga sin loader
    $('#tablaContenido').fadeIn(200);

    // ✅ Filtros AJAX
    $('#formFiltros').on('submit', function(e) {
        e.preventDefault();
        let datos = $(this).serialize();
        cargarTabla("{{ route('admin.controlaeronave.index') }}", datos);
    });

    // ✅ Paginación AJAX
    $(document).on('click', '#tablaContenido .pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        cargarTabla(url);
    });
});
</script>
<script>
$(function() {
    // ✅ UNA sola inicialización, sin ajax
    const table = $('#tablaPersonas').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        dom: '<"row mb-3"' +
            '<"col-sm-6 d-flex align-items-center"l>' +
            '<"col-sm-6 d-flex justify-content-end"f>' +
            '>' +
            't' +
            '<"row mt-3"' +
            '<"col-sm-5 d-flex align-items-center"i>' +
            '<"col-sm-7 d-flex justify-content-end"p>' +
            '>',
        columnDefs: [{
            orderable: false,
            targets: -1
        }],
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            zeroRecords: "No se encontraron resultados",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        }
    });


    // ✅ Confirmación estilo captura y eliminación vía fetch
    $(document).on('click', '.btn-eliminar', async function() {
        const btn = this;
        const url = btn.dataset.url;
        const token = btn.dataset.token;

        const r = await Swal.fire({
            html: `
        <div style="display:flex;flex-direction:column;align-items:center;gap:12px">
          <div style="width:96px;height:96px;border-radius:999px;border:6px solid #fde7cf;display:flex;align-items:center;justify-content:center">
            <span style="font-size:54px;color:#f59e0b">!</span>
          </div>
          <h2 style="margin:0;font-weight:800;color:#334155">¿Estás seguro?</h2>
          <p style="margin:0;color:#475569">Esta acción eliminará el registro permanentemente.</p>
        </div>
      `,
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            buttonsStyling: false,
            customClass: {
                popup: 'shadow rounded',
                confirmButton: 'btn btn-danger btn-lg mr-2',
                cancelButton: 'btn btn-primary btn-lg'
            }
        });

        if (!r.isConfirmed) return;

        try {
            const resp = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({
                    _method: 'DELETE'
                })
            });

            if (!resp.ok) {
                console.error(await resp.text());
                toastr.error('No se pudo eliminar');
                return;
            }

            // Quitar fila localmente (sin recargar)
            table.row($(btn).closest('tr')).remove().draw(false);
            toastr.success('Eliminado correctamente');
        } catch (e) {
            console.error(e);
            toastr.error('Error de red');
        }
    });
});
</script>

<script>
$(window).on('load', function() {
    $('#loaderGlobal').fadeOut(300);
    $('#tablaContenido').fadeIn(300);
});
</script>
@stop