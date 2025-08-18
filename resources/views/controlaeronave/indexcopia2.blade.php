

@extends('backend.menus.superior')


@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
<style>
/* Empuja el contenido hacia abajo si el navbar es fijo */
.content-wrapper {
    padding-top: 1rem;
}

@media (min-width: 992px) {

    /* Ajusta 64px si tu barra superior mide distinto (50–70px) */
    body .content-wrapper {
        margin-top: 90px;
    }
}

.table td,
.table th {
    vertical-align: middle;
}


@media (max-width: 767.98px) {
    body .content-wrapper {
        margin-top: 56px;
    }
}


/* Empuja el contenido por debajo del header fijo */
body.layout-navbar-fixed .wrapper>.content-wrapper {
    margin-top: 190px !important;
    /* ajusta 90–140 según necesites */
    padding-top: 1rem;
}

@media (max-width: 991.98px) {
    body.layout-navbar-fixed .wrapper>.content-wrapper {
        margin-top: 80px !important;
        /* offset menor en móvil */
    }
}

/* estética */
.table td,
.table th {
    vertical-align: middle
}

/* Offset solo en esta página */
.page-offset {
    margin-top: 120px;
}

@media (max-width: 991.98px) {
    .page-offset {
        margin-top: 80px;
    }
}

/* ====== Card estilo "Lista de Accesos" ====== */
.card-elevated {
    border: 0;
    border-radius: 14px;
    box-shadow: 0 8px 20px rgba(2, 72, 255, .08);
    overflow: hidden;
}

.card-titlebar {
    background: linear-gradient(90deg, #0d6efd 0%, #2671ff 60%, #2f57ff 100%);
    color: #fff;
    padding: .85rem 1.1rem;
    font-weight: 600;
}

.card-titlebar .btn {
    background: rgba(255, 255, 255, .15);
    border: 1px solid rgba(255, 255, 255, .35);
    color: #fff;
}

.card-titlebar .btn:hover {
    background: rgba(255, 255, 255, .25);
    color: #fff;
}

/* ====== Filtros ====== */
.filters .form-control,
.filters .form-select {
    height: 42px;
}

.filters .btn {
    height: 42px;
}

/* ====== Tabla ====== */
.table thead tr th {
    background: #2f57ff;
    color: #fff;
    font-weight: 500;
    border-color: #2a4be6;
    height: 10px;
}

.table tbody td {
    vertical-align: middle;
}

.table-hover tbody tr:hover {
    background: #f6f9ff;
}

.img-thumb {
    width: 56px;
    height: 56px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

/* ====== Botones de acción ====== */
.btn-edit {
    background: #0dcaf0;
    color: #fff;
    border: 0;
}

.btn-edit:hover {
    filter: brightness(0.95);
    color: #fff;
}

.btn-delete {
    background: #dc3545;
    color: #fff;
    border: 0;
}

.btn-delete:hover {
    filter: brightness(0.95);
    color: #fff;
}

/* Empuje por header fijo (ajusta si hace falta) */
body.layout-navbar-fixed .wrapper>.content-wrapper {
    margin-top: 110px !important;
}

@media(max-width: 991.98px) {
    body.layout-navbar-fixed .wrapper>.content-wrapper {
        margin-top: 80px !important;
    }
}

/* .form-control {
    width: 140px;
    height: 80px;
} */

/* tamaños cómodos para inputs del buscador */
.filters .w-200 {
    width: 180px;
}

/* N.º vuelo */

.filters .w-180 {
    width: 180px;
    /* fecha     */
}


/* que el select de "Mostrar" NO se estire */
.filters .form-select.w-auto {
    width: auto !important;
    min-width: 40px;

}


/* Fila de detalles: se oculta por defecto */
.details-row {
    display: none;
}

.details-row.show {
    display: table-row;
}

/* Grid bonito para los 37 campos */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 10px 16px;
    padding: 10px 6px;
}

.det-cell {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 8px 10px;
}

.det-cell small {
    color: #6c757d;
    display: block;
    margin-bottom: 2px;
}
</style>


@endsection



<div class="content-wrapper">
    {{-- Cabecera/espaciado --}}
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- <h1 class="h4 mb-0">Control acceso aeronave</h1> -->
            <!-- <a href="{{ route('admin.controlaeronave.create') }}" class="btn btn-outline-light text-primary"
                style="background:#e9f0ff;border-color:#cfe0ff">
                <i class="bi bi-pencil-square me-1"></i> Nuevo
            </a> -->
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-elevated">
                <div class="card-titlebar d-flex justify-content-between align-items-center">
                    <span>Lista de Accesos Aeronave</span>

                </div>

                <div class="card-body">

                    {{-- Filtros / topbar --}}
                    <form style="padding: 0 0 20px 0" method="GET"
                        class="filters row align-items-center gx-2 gy-2 mb-3">
                        <div class="col-auto d-flex align-items-center">
                            <label class="me-2 mb-0">Mostrar</label>
                            <select class="form-select form-select-sm w-auto" name="per_page"
                                onchange="this.form.submit()">
                                @php $pp = (int)request('per_page', 10); @endphp
                                @foreach([5,10,25,50] as $n)
                                <option value="{{ $n }}" @selected($pp==$n)>{{ $n }}</option>
                                @endforeach
                            </select>
                            <span class="ms-2">registros</span>
                        </div>

                        <div class="col-auto">
                            <input type="text" name="numero_vuelo" value="{{ request('numero_vuelo') }}"
                                class="form-control w-220" placeholder="N.º vuelo">
                        </div>

                        <!-- <div class="col-auto">
                            <input type="date" name="fecha" value="{{ request('fecha') }}" class="form-control w-180"
                                placeholder="dd/mm/aaaa">
                        </div> -->

                        <div class="col-auto">
                            <button class="btn btn-primary">
                                <i class="bi bi-search me-1"></i> Buscar
                            </button>
                        </div>

                        <div style="padding: 0 0 0 500px" class="col ms-auto">
                            <a href="{{ route('admin.controlaeronave.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil-square me-1"></i> Nuevo Acceso
                            </a>
                        </div>
                    </form>


                    {{-- Tabla --}}
                    <div class="table-responsive">
                        <table class="table table-hover" id="tablaCA">
                            <thead>
                                <tr>
                                    <th style="width:70px">#</th>
                                    <th>Fecha</th>
                                    <th>Vuelo</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Hora llegada</th>
                                    <th class="text-end" style="width:320px">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $it)
                                {{-- FILA PRINCIPAL --}}
                                <tr>
                                    <td>{{ $it->id_control_aeronave }}</td>
                                    <td>{{ $it->fecha }}</td>
                                    <td class="fw-semibold">{{ $it->numero_vuelo }}</td>
                                    <td class="text-uppercase">{{ $it->origen }}</td>
                                    <td class="text-capitalize">{{ $it->destino }}</td>
                                    <td>{{ $it->hora_llegada }}</td>
                                    <td class="text-end">

                                        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                            data-target="#accModal" data-control-id="{{ $it->id_control_aeronave }}"
                                            data-get-url="{{ route('accesos-personal.index', $it->id_control_aeronave) }}">
                                            Accesos
                                        </button>

                                        <button type="button" id="btn-{{ $it->id_control_aeronave }}"
                                            class="btn btn-outline-secondary btn-sm me-1"
                                            onclick="toggleDet({{ $it->id_control_aeronave }})"
                                            data-get-url="{{ route('accesos-personal.index', $it->id_control_aeronave) }}">
                                            Ver detalles
                                        </button>

                                        <a href="{{ route('admin.controlaeronave.edit', $it->id_control_aeronave) }}"
                                            class="btn btn-info btn-sm me-1">Editar</a>

                                        <button class="btn btn-danger btn-sm btn-eliminar"
                                            data-url="{{ route('admin.control.destroy', $it->id_control_aeronave) }}"
                                            data-token="{{ csrf_token() }}">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>

                                    </td>
                                </tr>

                                {{-- FILA DE DETALLES (37 CAMPOS) --}}
                                <tr id="det-{{ $it->id_control_aeronave }}" class="details-row bg-light">
                                    <td colspan="7">
                                        <div class="details-grid">
                                            {{-- básicos --}}
                                            <div class="det-cell"><small>ID control</small>
                                                <div class="fw-semibold">{{ $it->id_control_aeronave }}</div>
                                            </div>
                                            <div class="det-cell"><small>Fecha</small>
                                                <div class="fw-semibold">{{ $it->fecha ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Origen</small>
                                                <div class="fw-semibold">{{ $it->origen ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>N.º vuelo</small>
                                                <div class="fw-semibold">{{ $it->numero_vuelo ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Hora llegada</small>
                                                <div class="fw-semibold">{{ $it->hora_llegada ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Posición llegada</small>
                                                <div class="fw-semibold">{{ $it->posicion_llegada ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Matrícula / Operador</small>
                                                <div class="fw-semibold">{{ $it->matricula_operador ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Coordinador / Líder</small>
                                                <div class="fw-semibold">{{ $it->coordinador_lider ?? '—' }}</div>
                                            </div>

                                            {{-- procesos/tiempos --}}
                                            <div class="det-cell"><small>Desabordaje inicio</small>
                                                <div class="fw-semibold">{{ $it->desabordaje_inicio ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Desabordaje fin</small>
                                                <div class="fw-semibold">{{ $it->desabordaje_fin ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Inspección cabina inicio</small>
                                                <div class="fw-semibold">{{ $it->inspeccion_cabina_inicio ?? '—' }}
                                                </div>
                                            </div>
                                            <div class="det-cell"><small>Inspección cabina fin</small>
                                                <div class="fw-semibold">{{ $it->inspeccion_cabina_fin ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Aseo ingreso</small>
                                                <div class="fw-semibold">{{ $it->aseo_ingreso ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Aseo salida</small>
                                                <div class="fw-semibold">{{ $it->aseo_salida ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Tripulación ingreso</small>
                                                <div class="fw-semibold">{{ $it->tripulacion_ingreso ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Salida itinerario</small>
                                                <div class="fw-semibold">{{ $it->salida_itinerario ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Abordaje inicio</small>
                                                <div class="fw-semibold">{{ $it->abordaje_inicio ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Abordaje fin</small>
                                                <div class="fw-semibold">{{ $it->abordaje_fin ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Cierre puertas</small>
                                                <div class="fw-semibold">{{ $it->cierre_puertas ?? '—' }}</div>
                                            </div>

                                            {{-- seguridad --}}
                                            <div class="det-cell"><small>Agente / Oficial</small>
                                                <div class="fw-semibold">{{ $it->agente_nombre ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>ID Agente</small>
                                                <div class="fw-semibold">{{ $it->agente_id ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Firma (archivo)</small>
                                                <div class="fw-semibold">{{ $it->agente_firma ?? '—' }}</div>
                                            </div>

                                            {{-- demoras / pax --}}
                                            <div class="det-cell"><small>Demora (min)</small>
                                                <div class="fw-semibold">{{ $it->demora_tiempo ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Motivo demora</small>
                                                <div class="fw-semibold">{{ $it->demora_motivo ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Destino</small>
                                                <div class="fw-semibold">{{ $it->destino ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Total pax</small>
                                                <div class="fw-semibold">{{ $it->total_pax ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Hora real salida</small>
                                                <div class="fw-semibold">{{ $it->hora_real_salida ?? '—' }}</div>
                                            </div>

                                            {{-- extras (los 10 finales) --}}
                                            <div class="det-cell"><small>Nombre</small>
                                                <div class="fw-semibold">{{ $it->nombre ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>ID (persona)</small>
                                                <div class="fw-semibold">{{ $it->id ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Hora entrada</small>
                                                <div class="fw-semibold">{{ $it->hora_entrada ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Hora salida</small>
                                                <div class="fw-semibold">{{ $it->hora_salida ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Hora entrada 1</small>
                                                <div class="fw-semibold">{{ $it->hora_entrada1 ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Hora salida 1</small>
                                                <div class="fw-semibold">{{ $it->hora_salida1 ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Herramientas</small>
                                                <div class="fw-semibold">{{ $it->herramientas ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Empresa</small>
                                                <div class="fw-semibold">{{ $it->empresa ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Motivo</small>
                                                <div class="fw-semibold">{{ $it->motivo ?? '—' }}</div>
                                            </div>
                                            <div class="det-cell"><small>Firma (general)</small>
                                                <div class="fw-semibold">{{ $it->firma ?? '—' }}</div>
                                            </div>
                                        </div>

                                        <hr>
                                        <h6 class="mb-2">Accesos registrados</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nombre</th>
                                                        <th>ID</th>
                                                        <th>Entrada</th>
                                                        <th>Salida</th>
                                                        <th>Entrada 2</th>
                                                        <th>Salida 2</th>
                                                        <th>Herramientas</th>
                                                        <th>Empresa/Área</th>
                                                        <th>Motivo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detAccTbody-{{ $it->id_control_aeronave }}">
                                                    <tr>
                                                        <td colspan="10" class="text-muted">Sin datos</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Sin registros</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                    {{-- Pie: totales + paginación --}}
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            Mostrando {{ $items->firstItem() }} a {{ $items->lastItem() }} de un total de
                            {{ $items->total() }} registros
                        </small>
                        <div>
                            {{ $items->appends(request()->query())->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>



    <!-- MODAL PARA ACCESOS -->

    <div class="modal fade" id="accModal" tabindex="-1" role="dialog">

        <div class="modal-dialog modal-lg" role="document">
            <form id="accForm" method="POST" action="{{ route('accesos-personal.store') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="control_id" id="accControlId">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Datos de accesos</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nombre</label>
                                <input name="nombre" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Nombre</label>
                                <input name="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>ID</label>
                                <input name="id" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>ID control</label>
                                <input name="control_id" class="form-control">
                            </div>

                            <div class="col-md-3"><label>Hora Entrada</label><input type="time" name="hora_entrada"
                                    class="form-control"></div>
                            <div class="col-md-3"><label>Hora Salida</label><input type="time" name="hora_salida"
                                    class="form-control"></div>
                            <div class="col-md-3"><label>Hora Entrada 2</label><input type="time" name="hora_entrada1"
                                    class="form-control"></div>
                            <div class="col-md-3"><label>Hora Salida 2</label><input type="time" name="hora_salida1"
                                    class="form-control"></div>

                            <div class="col-md-6"><label>Herramientas</label><input name="herramientas"
                                    class="form-control"></div>
                            <div class="col-md-6"><label>Empresa y Área</label><input name="empresa"
                                    class="form-control"></div>

                            <div class="col-12">
                                <label>Motivo</label>
                                <textarea name="motivo" rows="2" class="form-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label>Firma (imagen)</label>
                                <input type="file" name="firma" class="form-control"
                                    accept="image/jpeg,image/png,image/webp,image/heic">
                            </div>
                        </div>

                        <hr>
                        <h6 class="mb-2">Accesos registrados</h6>
                        <div class="table-responsive">
                            <table class="table table-sm" id="accList">
                                <thead>
                                    <tr>
                                        <th>#sss</th>
                                        <th>Nombre</th>
                                        <th>ID</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary">Agregar acceso</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>



@extends('backend.menus.footerjs')
@section('content-admin-js')
<script>
// Abrir modal (Bootstrap 4 con jQuery)
$('#accModal').on('show.bs.modal', function (ev) {
  var btn = $(ev.relatedTarget);
  if (!btn.length) return;

  var controlId = btn.data('control-id');
  var getUrl    = btn.data('get-url');

  $('#accControlId').val(controlId);
  $('#accModal').data('getUrl', getUrl);

  // cargar lista en el modal
  cargarAccesosEnTabla(getUrl, document.querySelector('#accList tbody'));
});

// Envío AJAX del formulario del modal
$('#accForm').on('submit', function(e){
  e.preventDefault();
  var form = this;
  var fd   = new FormData(form);

  $.ajax({
    url: form.action,
    type: 'POST',
    data: fd,
    processData: false,
    contentType: false,
    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
    success: async function(resp){
      if (resp && resp.ok) {
        // refrescar tabla del modal
        var url = $('#accModal').data('getUrl');
        await cargarAccesosEnTabla(url, document.querySelector('#accList tbody'));

        // refrescar tabla de "Ver detalles" si está abierta
        var id = $('#accControlId').val();
        var detBody = document.getElementById('detAccTbody-' + id);
        if (detBody) await cargarAccesosDet(url, detBody);

        // cerrar modal (quitando foco primero para evitar warning de aria-hidden)
        $('#accModal :focus').blur();
        $('#accModal').modal('hide');
        form.reset();
      } else {
        // fallback si algo no vino en JSON
        location.reload();
      }
    },
    error: function(xhr){
      alert('No se pudo guardar. Revisa que control_id esté llegando.');
      console.log(xhr.responseText);
    }
  });
});

// Utilidades de carga
async function cargarAccesosEnTabla(url, tbody){
  try{
    const r = await fetch(url); const rows = await r.json();
    tbody.innerHTML = '';
    if (!rows.length) { tbody.innerHTML = '<tr><td colspan="5" class="text-muted">Sin datos</td></tr>'; return; }
    rows.forEach((x,i)=>{
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${i+1}</td>
        <td>${x.nombre||''}</td>
        <td>${x.id||''}</td>
        <td>${x.hora_entrada||''}</td>
        <td>${x.hora_salida||''}</td>`;
      tbody.appendChild(tr);
    });
  }catch(e){ tbody.innerHTML = '<tr><td colspan="5" class="text-danger">Error</td></tr>'; }
}

async function cargarAccesosDet(url, tbody){
  try{
    const r = await fetch(url); const rows = await r.json();
    tbody.innerHTML = '';
    if (!rows.length) { tbody.innerHTML = '<tr><td colspan="10" class="text-muted">Sin datos</td></tr>'; return; }
    rows.forEach((x,i)=>{
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${i+1}</td>
        <td>${x.nombre||''}</td>
        <td>${x.id||''}</td>
        <td>${x.hora_entrada||''}</td>
        <td>${x.hora_salida||''}</td>
        <td>${x.hora_entrada1||''}</td>
        <td>${x.hora_salida1||''}</td>
        <td>${x.herramientas||''}</td>
        <td>${x.empresa||''}</td>
        <td>${x.motivo||''}</td>`;
      tbody.appendChild(tr);
    });
  }catch(e){ tbody.innerHTML = '<tr><td colspan="10" class="text-danger">Error</td></tr>'; }
}

// Tu toggleDet ya está bien; solo asegúrate que el botón tenga data-get-url correcto.
</script>
@endsection



{{-- Scripts extra --}}
@yield('scripts')
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/delete.js') }}"></script>
@section('archivos-js')
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.main-header');
    const wrap = document.querySelector('.content-wrapper');
    if (header && wrap) {
        const h = Math.ceil(header.getBoundingClientRect().height);
        wrap.style.marginTop = (h + 20) + 'px'; // +20px de respiro
    }
});
</script>

@endsection



{{-- Scripts extra --}}
@yield('scripts')
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/delete.js') }}"></script>
@section('archivos-js')
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.main-header');
    const wrap = document.querySelector('.content-wrapper');
    if (header && wrap) {
        const h = Math.ceil(header.getBoundingClientRect().height);
        wrap.style.marginTop = (h + 20) + 'px'; // +20px de respiro
    }
});
</script>

@endsection