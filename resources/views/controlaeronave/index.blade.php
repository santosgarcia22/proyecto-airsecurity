@extends('backend.menus.superior')

@section('content-admin-css')
<style>
/* Fading del body: por defecto oculto, visible cuando .loaded */
body {

    transition: opacity .4s ease;
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




.table-overlay.show {
    display: flex;
}



@keyframes spin {
    100% {
        transform: rotate(360deg);
    }
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
@endsection


{{-- ===== Overlay global (solo al entrar) ===== --}}
<div id="loaderGlobal" class="loader" style="position:fixed;top:0;left:0;width:100%;height:100%;
background:white;z-index:9999;display:flex;align-items:center;justify-content:center">
    <div class="spinner"></div>
</div>


<div class="content">
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center"></div>
    </section>

    <section class="content">
        <div class="container-fluid limited">
            <div class="card card-elevated">
                <div class="card-titlebar d-flex justify-content-between align-items-center">
                    <span>Lista de Accesos Aeronave</span>
                </div>

                <div class="card-body">
                    {{-- Filtros --}}
                    <form id="formFiltros" class="filters row align-items-center gx-2 gy-2 mb-3" method="GET">
                        <div class="col-auto d-flex align-items-center">
                            <label class="me-2 mb-0">Mostrar</label>
                            <select class="form-select form-select-sm w-auto" name="per_page"
                                onchange="this.form.submit()">
                                @php $pp=(int)request('per_page',10); @endphp
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

                        <div class="col ms-auto" style="padding-left:0">
                            <a href="{{ route('admin.controlaeronave.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil-square me-1"></i> Registrar Tiempos y demoras
                            </a>
                        </div>
                    </form>

                    {{-- ===== Tabla + paginación (todo dentro de #tablaContenido) ===== --}}
                    <div id="tablaVuelos">

                        <div class="loader" id="loaderVuelos" style="display:none">
                            <div class="spinner"></div>
                        </div>


                        <div id="tablaContenido">
                            <div class="table-responsive">
                                <table class="table table-hover">
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
                                        <tr>
                                            <td>{{ $it->id_control_aeronave }}</td>
                                            <td>{{ $it->fecha }}</td>
                                            <td class="fw-semibold">{{ $it->numero_vuelo }}</td>
                                            <td class="text-uppercase">{{ $it->origen }}</td>
                                            <td class="text-capitalize">{{ $it->destino }}</td>
                                            <td>{{ $it->hora_llegada }}</td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm btn-opts">
                                                    @if($it->encabezado_ok)
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-toggle="modal" data-target="#accModal"
                                                        data-control-id="{{ $it->id_control_aeronave }}"
                                                        data-get-url="{{ route('accesos-personal.index',$it->id_control_aeronave) }}"
                                                        title="Accesos">
                                                        <i class="bi bi-people"></i> <span
                                                            class="btn-text">Accesos</span>
                                                    </button>
                                                    @else
                                                    <a href="{{ route('admin.controlaeronave.create',['vuelo_id'=>$it->id_control_aeronave]) }}"
                                                        class="btn btn-warning" title="Completar datos">
                                                        <i class="bi bi-clipboard-check"></i> <span
                                                            class="btn-text">Completar</span>
                                                    </a>
                                                    @endif

                                                    <button type="button" id="btn-{{ $it->id_control_aeronave }}"
                                                        class="btn btn-outline-secondary"
                                                        onclick="toggleDet({{ $it->id_control_aeronave }})"
                                                        title="Ver detalles">
                                                        <i class="bi bi-list-ul"></i> <span
                                                            class="btn-text">Detalles</span>
                                                    </button>

                                                    <a href="{{ route('admin.controlaeronave.edit',$it->id_control_aeronave) }}"
                                                        class="btn btn-info" title="Editar">
                                                        <i class="bi bi-pencil-square"></i> <span
                                                            class="btn-text">Editar</span>
                                                    </a>

                                                    <button class="btn btn-danger btn-sm btn-eliminar"
                                                        data-url="{{ route('admin.controlaeronave.destroy',$it->id_control_aeronave) }}"
                                                        data-token="{{ csrf_token() }}" title="Eliminar">
                                                        <i class="bi bi-trash"></i> <span
                                                            class="btn-text">Eliminar</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Fila de detalles --}}
                                        <tr id="det-{{ $it->id_control_aeronave }}" class="details-row bg-light">
                                            <td colspan="7">
                                                <div class="det-wrap">
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
                                                        @if(!empty($it->posicion_llegada)) <span class="chip"><i
                                                                class="bi bi-geo"></i> Pos
                                                            {{ $it->posicion_llegada }}</span> @endif
                                                        @if(!empty($it->matricula_operador)) <span class="chip"><i
                                                                class="bi bi-buildings"></i>
                                                            {{ $it->matricula_operador }}</span> @endif
                                                        @if(!empty($it->coordinador_lider)) <span class="chip"><i
                                                                class="bi bi-person-badge"></i>
                                                            {{ $it->coordinador_lider }}</span> @endif
                                                    </div>

                                                    <div class="section-block">
                                                        <div class="section-title"><i class="bi bi-truck"></i> Operación
                                                            en tierra</div>
                                                        <div class="kv-grid">
                                                            <div class="kv"><small>Desabordaje inicio</small>
                                                                <div class="v">{{ $it->desabordaje_inicio ?? '—' }}
                                                                </div>
                                                            </div>
                                                            <div class="kv"><small>Desabordaje fin</small>
                                                                <div class="v">{{ $it->desabordaje_fin ?? '—' }}</div>
                                                            </div>
                                                            <div class="kv"><small>Inspección cabina inicio</small>
                                                                <div class="v">
                                                                    {{ $it->inspeccion_cabina_inicio ?? '—' }}</div>
                                                            </div>
                                                            <div class="kv"><small>Inspección cabina fin</small>
                                                                <div class="v">{{ $it->inspeccion_cabina_fin ?? '—' }}
                                                                </div>
                                                            </div>
                                                            <div class="kv"><small>Aseo ingreso</small>
                                                                <div class="v">{{ $it->aseo_ingreso ?? '—' }}</div>
                                                            </div>
                                                            <div class="kv"><small>Aseo salida</small>
                                                                <div class="v">{{ $it->aseo_salida ?? '—' }}</div>
                                                            </div>
                                                            <div class="kv"><small>Tripulación ingreso</small>
                                                                <div class="v">{{ $it->tripulacion_ingreso ?? '—' }}
                                                                </div>
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

                                                    <div class="section-block">
                                                        <div class="section-title"><i class="bi bi-shield-check"></i>
                                                            Seguridad</div>
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

                                                    <div class="section-block">
                                                        <div class="section-title"><i class="bi bi-hourglass-split"></i>
                                                            Demoras &amp; Pax</div>
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

                                                    <hr class="my-2">
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
                        </div> {{-- /#tablaContenido --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL Accesos --}}
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
                            <div class="col-md-6"><label>ID CONTROL</label><input class="form-control"
                                    id="accControlIdView" readonly></div>
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
                            <div class="col-md-6"><label>Firma (imagen)</label><input type="file" name="firma"
                                    class="form-control" accept="image/jpeg,image/png,image/webp,image/heic"></div>
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

{{-- ===== Vendors ===== --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- ===== Overlay global: entra/volver ===== --}}
<!-- <script>
    /* Quita el loader cuando:
    - terminó window.load
    - y confirmamos en 1–2 frames que el CSS ya está aplicado
    (fail-safe cortito de 300ms)
    */
    (function() {
        const $loader = $('#loaderGlobal');
        const $tabla = $('#tablaContenido');

        // Volver vía bfcache: la página ya está pintada.
        window.addEventListener('pageshow', (e) => {
            if (e.persisted) {
                $loader.hide();
                $tabla.show();
            }
        });

        function stylesAppliedOK() {
            const el = document.querySelector('.card-titlebar');
            if (!el) return true;
            const cs = getComputedStyle(el);
            return cs.backgroundImage && cs.backgroundImage !== 'none';
        }

        function waitCSSApplied(maxMs = 300) {
            return new Promise((resolve) => {
                const t0 = performance.now();
                (function tick() {
                    if (stylesAppliedOK()) return resolve();
                    if (performance.now() - t0 > maxMs) return resolve(); // fail-safe corto
                    requestAnimationFrame(tick);
                })();
            });
        }

        $(window).on('load', async function() {
            // pequeño colchón para que Bootstrap/AdminLTE asienten layout
            await waitCSSApplied(300);
            // doble rAF para asegurar el siguiente paint estable
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    $loader.fadeOut(200, () => $tabla.fadeIn(200));
                });
            });
        });
    })();
</script> -->

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

{{-- ===== Modal Accesos ===== --}}
<script>
$('#accModal').on('show.bs.modal', function(ev) {
    const btn = $(ev.relatedTarget);
    const controlId = btn?.data('control-id') || '';
    const getUrl = btn?.data('get-url') || '';

    $('#accControlIdView').val(controlId);
    $('#accControlId').val(controlId);
    $(this).data('getUrl', getUrl);

    if (getUrl) cargarAccesosEnTabla(getUrl, document.querySelector('#accList tbody'));
});

$('#accForm').on('submit', function(e) {
    e.preventDefault();
    const controlId = $('#accControlId').val();
    if (!controlId) {
        alert('Falta el control_id. Abre el modal desde el botón "Accesos".');
        return;
    }

    const fd = new FormData(this);
    fd.set('control_id', controlId);

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
                $('#accForm')[0].reset();
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
          <td>${x.hora_salida||''}</td>`;
            tbody.appendChild(tr);
        });
    } catch {
        tbody.innerHTML = '<tr><td colspan="5" class="text-danger">Error</td></tr>';
    }
}

// Toggle de detalles
function toggleDet(id) {
    const tr = document.getElementById('det-' + id);
    const btn = document.getElementById('btn-' + id);
    if (!tr) return;
    tr.classList.toggle('show');
    if (btn) btn.textContent = tr.classList.contains('show') ? 'Ocultar' : 'Ver detalles';
}
</script>

{{-- ===== Ajuste de margen (si tu header es fijo) ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.main-header');
    const wrap = document.querySelector('.content-wrapper');
    if (header && wrap) {
        const h = Math.ceil(header.getBoundingClientRect().height);
        wrap.style.marginTop = (h + 20) + 'px';
    }
});
</script>

{{-- ===== Scripts locales ===== --}}
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/delete.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>

<script>
$(window).on('load', function() {
    $('#loaderGlobal').fadeOut(300);
    $('#tablaContenido').fadeIn(300);
});
</script>