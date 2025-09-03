@extends('backend.menus.superior')

@section('content-admin-css')

<style>
body {
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.3s ease;
}

body.loaded {
    visibility: visible;
    opacity: 1;
}



/* ====== layout/espaciado ====== */
.content-wrapper {
    padding-top: 1rem
}

.page-overlay {
    position: fixed;
    inset: 0;
    background: rgba(255, 255, 255, .7);
    display: none;
    z-index: 9999;
}

.page-overlay.show {
    display: block;
}


/* ====== Layout en pantallas MUY anchas ====== */
@media (min-width: 1400px) {
    .container-fluid.limited {
        max-width: 1400px;
        /* 1280–1440 funciona bien */
        margin-left: auto;
        margin-right: auto;
    }
}

/* ====== Tabla ====== */
.table thead th {
    white-space: nowrap;
}

.table td {
    vertical-align: middle;
}

.text-tight {
    white-space: nowrap;
}

/* Columna Opciones: ancho adaptativo */
@media (min-width: 1200px) {
    .col-opts {
        width: 360px;
    }
}

@media (min-width: 992px) and (max-width:1199.98px) {
    .col-opts {
        width: 300px;
    }
}

@media (max-width: 991.98px) {
    .col-opts {
        width: 1%;
    }
}

/* que no empuje la fila */

/* Grupo de botones responsive */
.btn-opts {
    display: inline-flex;
    gap: .35rem;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.btn-opts .btn {
    padding-inline: .55rem;
}

/* En pantallas chicas, solo íconos; en grandes, ícono + texto */
.btn-text {
    display: none;
}

@media (min-width: 1200px) {
    .btn-text {
        display: inline;
    }
}

/* xl en adelante */

/* Filtros: que respiren y no se rompan */
.filters .form-control,
.filters .form-select,
.filters .btn {
    height: 42px;
}

@media (max-width: 767.98px) {

    .filters .col-auto,
    .filters .ms-auto {
        width: 100%;
    }

    .filters .w-220 {
        width: 100% !important;
    }
}

/* Celdas de detalle: grid más flexible en móviles */
@media (max-width: 575.98px) {
    .kv-grid {
        grid-template-columns: 1fr;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }
}


.table td,
.table th {
    vertical-align: middle
}

/* ====== card / header ====== */
.card-elevated {
    border: 0;
    border-radius: 14px;
    box-shadow: 0 8px 20px rgba(2, 72, 255, .08);
    overflow: hidden
}

.card-titlebar {
    background: linear-gradient(90deg, #0d6efd 0%, #2671ff 60%, #2f57ff 100%);
    color: #fff;
    padding: .85rem 1.1rem;
    font-weight: 600
}

.card-titlebar .btn {
    background: rgba(255, 255, 255, .15);
    border: 1px solid rgba(255, 255, 255, .35);
    color: #fff
}

.card-titlebar .btn:hover {
    background: rgba(255, 255, 255, .25);
    color: #fff
}

/* ====== filtros ====== */
.filters .form-control,
.filters .form-select {
    height: 42px
}

.filters .btn {
    height: 42px
}

.filters .w-200 {
    width: 180px
}

/* ====== tabla principal ====== */
.table thead tr th {
    background: #2f57ff;
    color: #fff;
    font-weight: 900;
    border-color: #2a4be6;
    height: 5px
}

.table-hover tbody tr:hover {
    background: #f6f9ff
}

/* ====== fila detalles ====== */
.details-row {
    display: none
}

.details-row.show {
    display: table-row
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 10px 16px;
    padding: 10px 6px
}

.det-cell {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 8px 10px
}

.det-cell small {
    color: #6c757d;
    display: block;
    margin-bottom: 2px
}

/* ===== Detalles: layout por secciones ===== */
.det-wrap {
    padding: 6px 0;
}

.summary-chips {
    display: flex;
    flex-wrap: wrap;
    gap: .5rem;
    margin: .25rem 0 10px;
}

.summary-chips .chip {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    background: #f6f9ff;
    border: 1px solid #e7eefb;
    border-radius: 999px;
    padding: 6px 10px;
    font-size: .86rem;
    color: #224;
}

.section-block {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 12px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: .5rem;
    background: #eff4ff;
    color: #2847ff;
    font-weight: 600;
    padding: 8px 12px;
    border-bottom: 1px solid #e3e9ff;
    font-size: .93rem;
}

.kv-grid {
    padding: 10px 12px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px 16px;
}

.kv {
    background: #fff;
    border: 1px dashed #e9ecef;
    border-radius: 10px;
    padding: 8px 10px;
}

.kv small {
    display: block;
    color: #6c757d;
    margin-bottom: 2px;
}

.kv .v {
    font-weight: 600;
    color: #1b2430;
}

.firma-thumb {
    height: 60px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
}

    /* 
    css de preloader */
#preloader {
  position: fixed;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff;
  z-index: 9999;
}
body.loaded #preloader {
  display: none;
}

/* tabla de accesos dentro de detalles, tal cual la tienes */
</style>
@endsection


<div class="content-wrapper">
    {{-- Cabecera/espaciado --}}
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center"></div>
    </section>

    <div id="preloader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>



    <section class="content">
        <div class="container-fluid limited">
            <div class="card card-elevated">
                <div class="card-titlebar d-flex justify-content-between align-items-center">
                    <span>Lista de Accesos Aeronave</span>
                </div>

                <div class="card-body">
                    {{-- Filtros --}}
                    <form style="padding:0 0 20px 0" method="GET" class="filters row align-items-center gx-2 gy-2 mb-3">
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

                        <div class="col-auto">
                            <button class="btn btn-primary"><i class="bi bi-search me-1"></i> Buscar</button>
                        </div>

                        <div class="col ms-auto" style="padding-left: 0">
                            <a href="{{ route('admin.controlaeronave.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil-square me-1"></i> Registrar Tiempos y demoras
                            </a>
                        </div>
                    </form>

                    {{-- Tabla principal --}}
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
                                    <th class="text-end text-tight col-opts">Opciones</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $it)
                                {{-- Fila principal --}}
                                <tr>
                                    <td>{{ $it->id_control_aeronave }}</td>
                                    <td>{{ $it->fecha }}</td>
                                    <td class="fw-semibold">{{ $it->numero_vuelo }}</td>
                                    <td class="text-uppercase">{{ $it->origen }}</td>
                                    <td class="text-capitalize">{{ $it->destino }}</td>
                                    <td>{{ $it->hora_llegada }}</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm btn-opts">

                                            {{-- Accesos / Completar --}}
                                            @if($it->encabezado_ok)
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                                data-target="#accModal" data-control-id="{{ $it->id_control_aeronave }}"
                                                data-get-url="{{ route('accesos-personal.index', $it->id_control_aeronave) }}"
                                                title="Accesos">
                                                <i class="bi bi-people"></i> <span class="btn-text">Accesos</span>
                                            </button>
                                            @else
                                            <a href="{{ route('admin.controlaeronave.create', ['vuelo_id' => $it->id_control_aeronave]) }}"
                                                class="btn btn-warning" title="Completar datos">
                                                <i class="bi bi-clipboard-check"></i> <span
                                                    class="btn-text">Completar</span>
                                            </a>
                                            @endif

                                            {{-- Ver/Ocultar detalles --}}
                                            <button type="button" id="btn-{{ $it->id_control_aeronave }}"
                                                class="btn btn-outline-secondary"
                                                onclick="toggleDet({{ $it->id_control_aeronave }})"
                                                title="Ver detalles">
                                                <i class="bi bi-list-ul"></i> <span class="btn-text">Detalles</span>
                                            </button>

                                            {{-- Editar --}}
                                            <a href="{{ route('admin.controlaeronave.edit', $it->id_control_aeronave) }}"
                                                class="btn btn-info" title="Editar">
                                                <i class="bi bi-pencil-square"></i> <span class="btn-text">Editar</span>
                                            </a>

                                            {{-- Eliminar --}}
                                            <button class="btn btn-danger btn-sm btn-eliminar"
                                                data-url="{{ route('admin.controlaeronave.destroy', $it->id_control_aeronave) }}"
                                                data-token="{{ csrf_token() }}" title="Eliminar">
                                                <i class="bi bi-trash"></i> <span class="btn-text">Eliminar</span>
                                            </button>

                                        </div>
                                    </td>

                                    <!-- <div class="dropdown d-md-none">
                                        <button class="btn btn-outline-secondary btn-sm" data-toggle="dropdown"
                                            title="Opciones">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                         poner aquí los <a> o <button> con las mismas acciones 

                                            {{-- Accesos / Completar --}}
                                            @if($it->encabezado_ok)
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                                data-target="#accModal" data-control-id="{{ $it->id_control_aeronave }}"
                                                data-get-url="{{ route('accesos-personal.index', $it->id_control_aeronave) }}"
                                                title="Accesos">
                                                <i class="bi bi-people"></i> <span class="btn-text">Accesos</span>
                                            </button>
                                            @else
                                            <a href="{{ route('admin.controlaeronave.create', ['vuelo_id' => $it->id_control_aeronave]) }}"
                                                class="btn btn-warning" title="Completar datos">
                                                <i class="bi bi-clipboard-check"></i> <span
                                                    class="btn-text">Completar</span>
                                            </a>
                                            @endif

                                            {{-- Ver/Ocultar detalles --}}
                                            <button type="button" id="btn-{{ $it->id_control_aeronave }}"
                                                class="btn btn-outline-secondary"
                                                onclick="toggleDet({{ $it->id_control_aeronave }})"
                                                title="Ver detalles">
                                                <i class="bi bi-list-ul"></i> <span class="btn-text">Detalles</span>
                                            </button>

                                            {{-- Editar --}}
                                            <a href="{{ route('admin.controlaeronave.edit', $it->id_control_aeronave) }}"
                                                class="btn btn-info" title="Editar">
                                                <i class="bi bi-pencil-square"></i> <span class="btn-text">Editar</span>
                                            </a>

                                            {{-- Eliminar --}}
                                            <button class="btn btn-danger btn-sm btn-eliminar"
                                                data-url="{{ route('admin.controlaeronave.destroy', $it->id_control_aeronave) }}"
                                                data-token="{{ csrf_token() }}" title="Eliminar">
                                                <i class="bi bi-trash"></i> <span class="btn-text">Eliminar</span>
                                            </button>

                                        </div>
                                    </div> -->


                                </tr>


                                <!-- <button class="btn btn-danger btn-sm btn-eliminar"
                                    data-url="{{ route('admin.controlaeronave.destroy', $it->id_control_aeronave) }}"
                                    data-token="{{ csrf_token() }}">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button> -->

                                {{-- Fila de DETALLES (no tocamos el diseño de la tabla inferior) --}}
                                <tr id="det-{{ $it->id_control_aeronave }}" class="details-row bg-light">
                                    <td colspan="7">
                                        <div class="det-wrap">
                                            {{-- Resumen de cabecera en chips --}}
                                            <div class="summary-chips">
                                                <span class="chip"><i class="bi bi-hash"></i>
                                                    {{ $it->id_control_aeronave }}</span>
                                                <span class="chip"><i class="bi bi-calendar-event"></i>
                                                    {{ $it->fecha ?? '—' }}</span>
                                                <span class="chip"><i class="bi bi-airplane"></i> Vuelo
                                                    {{ $it->numero_vuelo ?? '—' }}</span>
                                                <span class="chip"><i class="bi bi-geo-alt"></i>
                                                    {{ $it->origen ?? '—' }} → {{ $it->destino ?? '—' }}</span>
                                                <span class="chip"><i class="bi bi-clock"></i> Llegada
                                                    {{ $it->hora_llegada ?? '—' }}</span>
                                                @if(!empty($it->posicion_llegada))
                                                <span class="chip"><i class="bi bi-geo"></i> Pos
                                                    {{ $it->posicion_llegada }}</span>
                                                @endif
                                                @if(!empty($it->matricula_operador))
                                                <span class="chip"><i class="bi bi-buildings"></i>
                                                    {{ $it->matricula_operador }}</span>
                                                @endif
                                                @if(!empty($it->coordinador_lider))
                                                <span class="chip"><i class="bi bi-person-badge"></i>
                                                    {{ $it->coordinador_lider }}</span>
                                                @endif
                                            </div>

                                            {{-- Sección: Operación en tierra --}}
                                            <div class="section-block">
                                                <div class="section-title"><i class="bi bi-truck"></i> Operación en
                                                    tierra</div>
                                                <div class="kv-grid">
                                                    <div class="kv"><small>Desabordaje inicio</small>
                                                        <div class="v">{{ $it->desabordaje_inicio ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Desabordaje fin</small>
                                                        <div class="v">{{ $it->desabordaje_fin ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Inspección cabina inicio</small>
                                                        <div class="v">{{ $it->inspeccion_cabina_inicio ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Inspección cabina fin</small>
                                                        <div class="v">{{ $it->inspeccion_cabina_fin ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Aseo ingreso</small>
                                                        <div class="v">{{ $it->aseo_ingreso ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Aseo salida</small>
                                                        <div class="v">{{ $it->aseo_salida ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Tripulación ingreso</small>
                                                        <div class="v">{{ $it->tripulacion_ingreso ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Salida itinerario</small>
                                                        <div class="v">{{ $it->salida_itinerario ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Abordaje inicio</small>
                                                        <div class="v">{{ $it->abordaje_inicio ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Abordaje fin</small>
                                                        <div class="v">{{ $it->abordaje_fin ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Cierre puertas</small>
                                                        <div class="v">{{ $it->cierre_puerta ?? '—' }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Sección: Seguridad --}}
                                            <div class="section-block">
                                                <div class="section-title"><i class="bi bi-shield-check"></i> Seguridad
                                                </div>
                                                <div class="kv-grid">
                                                    <div class="kv"><small>Agente / Oficial</small>
                                                        <div class="v">{{ $it->agente_nombre ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>ID Agente</small>
                                                        <div class="v">{{ $it->agente_id ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv">
                                                        <small>Firma (archivo)</small>
                                                        <div class="v">
                                                            @if(!empty($it->agente_firma))
                                                            <a href="{{ Storage::url($it->agente_firma) }}"
                                                                target="_blank">
                                                                <img src="{{ Storage::url($it->agente_firma) }}"
                                                                    alt="Firma" class="firma-thumb">
                                                            </a>
                                                            @else — @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Sección: Demoras y Pax --}}
                                            <div class="section-block">
                                                <div class="section-title"><i class="bi bi-hourglass-split"></i> Demoras
                                                    &amp; Pax</div>
                                                <div class="kv-grid">
                                                    <div class="kv"><small>Demora (min)</small>
                                                        <div class="v">{{ $it->demora_tiempo ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Motivo demora</small>
                                                        <div class="v">{{ $it->demora_motivo ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Total pax</small>
                                                        <div class="v">{{ $it->total_pax ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Hora real salida</small>
                                                        <div class="v">{{ $it->hora_real_salida ?? '—' }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- {{-- Sección: Registro extra (los 10 finales que ya tenías) --}}
                                            <div class="section-block">
                                                <div class="section-title"><i class="bi bi-journal-text"></i> Registro
                                                    extra</div>
                                                <div class="kv-grid">
                                                    <div class="kv"><small>Nombre</small>
                                                        <div class="v">{{ $it->nombre ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>ID (persona)</small>
                                                        <div class="v">{{ $it->id ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Hora entrada</small>
                                                        <div class="v">{{ $it->hora_entrada ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Hora salida</small>
                                                        <div class="v">{{ $it->hora_salida ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Hora entrada 1</small>
                                                        <div class="v">{{ $it->hora_entrada1 ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Hora salida 1</small>
                                                        <div class="v">{{ $it->hora_salida1 ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Herramientas</small>
                                                        <div class="v">{{ $it->herramientas ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Empresa</small>
                                                        <div class="v">{{ $it->empresa ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv"><small>Motivo</small>
                                                        <div class="v">{{ $it->motivo ?? '—' }}</div>
                                                    </div>
                                                    <div class="kv">
                                                        <small>Firma (general)</small>
                                                        <div class="v">
                                                            @if(!empty($it->firma))
                                                            <a href="{{ Storage::url($it->firma) }}" target="_blank">
                                                                <img src="{{ Storage::url($it->firma) }}" alt="Firma"
                                                                    class="firma-thumb">
                                                            </a>
                                                            @else — @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <hr class="my-2">

                                            {{-- Accesos registrados (tu tabla, sin cambios) --}}
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
                        <div>{{ $items->appends(request()->query())->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- MODAL Accesos (diseño intacto) --}}
    <div class="modal fade" id="accModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form id="accForm" method="POST" action="{{ route('accesos-personal.store') }}"
                enctype="multipart/form-data">
                @csrf


                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Datos de accesos</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6"><label>Nombre</label><input name="nombre" class="form-control"
                                    required></div>


                            <!-- campo visible (solo para mostrar) -->
                            <div class="col-md-6">
                                <label>ID CONTROL</label>
                                <input class="form-control" id="accControlIdView" readonly>
                            </div>

                            <!-- Este es el ÚNICO que se envía -->
                            <!-- ÚNICO hidden que se envía -->
                            <input type="hidden" name="control_id" id="accControlId">


                            <div class="col-md-6"><label>ID</label><input name="id" class="form-control"></div>

                            <div class="col-md-3"><label>Hora Entrada</label><input type="time" name="hora_entrada"
                                    class="form-control"></div>
                            <div class="col-md-3"><label>Hora Salida</label><input type="time" name="hora_salida"
                                    class="form-control"></div>
                            <div class="col-md-3"><label>Hora Entrada 2</label><input type="time" name="hora_entrada1"
                                    class="form-control"></div>
                            <div class="col-md-3"><label>Hora Salida 2</label><input type="time" name="hora_salida2"
                                    class="form-control"></div>

                            <div class="col-md-6"><label>Herramientas</label><input name="herramientas"
                                    class="form-control"></div>
                            <div class="col-md-6"><label>Empresa y Área</label><input name="empresa"
                                    class="form-control"></div>

                            <div class="col-12"><label>Motivo</label><textarea name="motivo" rows="2"
                                    class="form-control"></textarea></div>

                            <div class="col-md-6"><label>Firma (imagen)</label>
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
                                        <th>#</th>
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

<script>
document.querySelector('.filters').addEventListener('submit', function(e) {
    e.preventDefault();
    const url = this.action || window.location.pathname;
    const params = new URLSearchParams(new FormData(this)).toString();

    fetch(url + '?' + params, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.text())
        .then(html => {
            // suponiendo que el servidor devuelve un partial con solo la tabla
            document.querySelector('#tablaCA').innerHTML =
                $(html).find('#tablaCA').html();
        });
});
</script>



@extends('backend.menus.footerjs')
@section('content-admin-js')
<script>
document.addEventListener("DOMContentLoaded", () => {
    // asegura que la página se muestre aunque no haya cargado TODO
    setTimeout(() => {
        document.body.classList.add('loaded');
    }, 200); // 200ms, ajustable
});
</script>


{{-- jQuery + Bootstrap 4.6 bundle (incluye Popper) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toOpen = "{{ request('open') }}";
    if (toOpen) {
        const btn = document.querySelector(
            `button[data-control-id="${toOpen}"][data-target="#accModal"]`
        );
        if (btn) btn.click();
    }
});
</script>


</script>
<script>
// --- Al abrir el modal, carga la tabla del modal
$('#accModal').on('show.bs.modal', function(ev) {
    const btn = $(ev.relatedTarget); // <button Accesos ...>
    const controlId = btn.data('control-id') || '';
    const getUrl = btn.data('get-url') || '';

    // setear visible + hidden
    $('#accControlIdView').val(controlId);
    $('#accControlId').val(controlId);

    // guarda la url para recargar la tabla
    $(this).data('getUrl', getUrl);

    if (getUrl) {
        cargarAccesosEnTabla(getUrl, document.querySelector('#accList tbody'));
    }
});


// --- Enviar el form por AJAX y esperar JSON
$('#accForm').on('submit', function(e) {
    e.preventDefault();

    const controlId = $('#accControlId').val();
    if (!controlId) {
        alert('Falta el control_id. Abre el modal desde el botón "Accesos" de la fila.');
        return;
    }

    const fd = new FormData(this);
    fd.set('control_id', controlId); // fuerza el valor correcto

    $.ajax({
        url: this.action,
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        success: async (resp) => {
            if (resp && resp.ok) {
                const url = $('#accModal').data('getUrl');
                await cargarAccesosEnTabla(url, document.querySelector('#accList tbody'));
                $('#accModal :focus').blur();
                $('#accModal').modal('hide');
                $('#accForm')[0].reset(); // <-- arregla el form.reset() que antes no existía
            }
        },
        error: (xhr) => {
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                let msg = 'Revisa los datos:\n';
                for (const k in xhr.responseJSON.errors) msg +=
                    `- ${xhr.responseJSON.errors[k][0]}\n`;
                alert(msg);
            } else {
                console.log(xhr.responseText);
                alert('Error al guardar el acceso.');
            }
        }
    });
});


// --- Helpers para cargar tablas (modal y detalle)
async function cargarAccesosEnTabla(url, tbody) {
    try {
        const r = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const rows = await r.json();
        tbody.innerHTML = '';
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-muted">Sin datos</td></tr>';
            return;
        }
        rows.forEach((x, i) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${i+1}</td>
                <td>${x.nombre||''}</td>
                <td>${x.id||''}</td>
                <td>${x.hora_entrada||''}</td>
                <td>${x.hora_salida||''}</td>
            `;
            tbody.appendChild(tr);
        });
    } catch {
        tbody.innerHTML = '<tr><td colspan="5" class="text-danger">Error</td></tr>';
    }
}

async function cargarAccesosDet(url, tbody) {
    try {
        const r = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const rows = await r.json();
        tbody.innerHTML = '';
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-muted">Sin datos</td></tr>';
            return;
        }
        rows.forEach((x, i) => {
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
                <td>${x.motivo||''}</td>
            `;
            tbody.appendChild(tr);
        });
    } catch {
        tbody.innerHTML = '<tr><td colspan="10" class="text-danger">Error</td></tr>';
    }
}

// --- Tu toggle de detalles (como lo tenías)
function toggleDet(id) {
    const tr = document.getElementById('det-' + id);
    const btn = document.getElementById('btn-' + id);
    if (!tr) return;
    tr.classList.toggle('show');
    if (btn) btn.textContent = tr.classList.contains('show') ? 'Ocultar' : 'Ver detalles';
}
</script>



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