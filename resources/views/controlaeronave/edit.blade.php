@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />

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
@endsection


<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid mt-3">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Control acceso aeronave - Editar</h4>
                </div>

                <form action="{{ route('admin.controlaeronave.update', $control->id_control_aeronave) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Tabs -->
                            <div class="nav flex-lg-column nav-pills gap-2" role="tablist">
                                <a class="nav-link active" data-toggle="pill" href="#tab-base" role="tab"
                                    aria-controls="tab-base" aria-selected="true">
                                    1. Datos base
                                </a>
                                <a class="nav-link" data-toggle="pill" href="#tab-procesos" role="tab"
                                    aria-controls="tab-procesos" aria-selected="false">
                                    2. Procesos / tiempos
                                </a>
                                <a class="nav-link" data-toggle="pill" href="#tab-demoras" role="tab"
                                    aria-controls="tab-demoras" aria-selected="false">
                                    3. Demoras y pax
                                </a>
                                <a class="nav-link" data-toggle="pill" href="#tab-seg" role="tab"
                                    aria-controls="tab-seg" aria-selected="false">
                                    4. Seguridad / adjuntos
                                </a>
                                <a class="nav-link" data-toggle="pill" href="#tab-acce" role="tab"
                                    aria-controls="tab-seg" aria-selected="false">
                                    5. Datos de Acceso
                                </a>
                            </div>


                            <!-- Content -->
                            <div class="col-lg-9">
                                <div class="tab-content">

                                    {{-- 1 DATOS BASE --}}
                                    <div class="tab-pane fade show active" id="tab-base">
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <label class="form-label">Fecha</label>
                                                <input type="date" name="fecha" class="form-control"
                                                    value="{{ old('fecha', $control->fecha ?? '') }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Origen</label>
                                                <input type="text" name="origen" class="form-control"
                                                    value="{{ old('origen', $control->origen ?? '') }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">N.º de vuelo (origen)</label>
                                                <input type="text" name="numero_vuelo" class="form-control"
                                                    value="{{ old('numero_vuelo', $control->numero_vuelo ?? '') }}">
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="form-label">Hora de llegada</label>
                                                <input type="time" name="hora_llegada" class="form-control"
                                                    value="{{ old('hora_llegada', $control->hora_llegada ?? '') }}">
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="form-label">Posición de llegada</label>
                                                <input type="text" name="posicion_llegada" class="form-control"
                                                    value="{{ old('posicion_llegada', $control->posicion_llegada ?? '') }}">
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Matrícula y operador (TAI, LRC, AV GUG,
                                                    ...)</label>
                                                <input type="text" name="matricula_operador" class="form-control"
                                                    value="{{ old('matricula_operador', $control->matricula_operador ?? '') }}">
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-label">Coordinador / Líder de vuelo</label>
                                                <input type="text" name="coordinador_lider" class="form-control"
                                                    value="{{ old('coordinador_lider', $control->coordinador_lider ?? '') }}">
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
                                                                class="form-control"
                                                                value="{{ old('desabordaje_inicio', $control->desabordaje_inicio ?? '') }}">
                                                        </td>
                                                        <td><input type="time" name="desabordaje_fin"
                                                                class="form-control"
                                                                value="{{ old('desabordaje_fin', $control->desabordaje_fin ?? '') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Inspección cabina</td>
                                                        <td><input type="time" name="inspeccion_cabina_inicio"
                                                                class="form-control"
                                                                value="{{ old('inspeccion_cabina_inicio', $control->inspeccion_cabina_inicio ?? '') }}">
                                                        </td>
                                                        <td><input type="time" name="inspeccion_cabina_fin"
                                                                class="form-control"
                                                                value="{{ old('inspeccion_cabina_fin', $control->inspeccion_cabina_fin ?? '') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Aseo (personal)</td>
                                                        <td><input type="time" name="aseo_ingreso" class="form-control"
                                                                value="{{ old('aseo_ingreso', $control->aseo_ingreso ?? '') }}">
                                                        </td>
                                                        <td><input type="time" name="aseo_salida" class="form-control"
                                                                value="{{ old('aseo_salida', $control->aseo_salida ?? '') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tripulación</td>
                                                        <td><input type="time" name="tripulacion_ingreso"
                                                                class="form-control"
                                                                value="{{ old('tripulacion_ingreso', $control->tripulacion_ingreso ?? '') }}">
                                                        </td>
                                                        <td><input type="time" name="salida_itinerario"
                                                                class="form-control"
                                                                value="{{ old('salida_itinerario', $control->salida_itinerario ?? '') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Abordaje</td>
                                                        <td><input type="time" name="abordaje_inicio"
                                                                class="form-control"
                                                                value="{{ old('abordaje_inicio', $control->abordaje_inicio ?? '') }}">
                                                        </td>
                                                        <td><input type="time" name="abordaje_fin" class="form-control"
                                                                value="{{ old('abordaje_fin', $control->abordaje_fin ?? '') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cierre de puertas</td>
                                                        <td><input type="time" name="cierre_puertas"
                                                                class="form-control"
                                                                value="{{ old('cierre_puertas', $control->cierre_puertas ?? '') }}">
                                                        </td>
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
                                                <label class="form-label">Demora (min)</label>
                                                <input type="number" min="0" name="demora_tiempo" class="form-control"
                                                    value="{{ old('demora_tiempo', $control->demora_tiempo ?? '') }}">
                                            </div>
                                            <div class="col-sm-9">
                                                <label class="form-label">Motivo de demora</label>
                                                <input type="text" name="demora_motivo" class="form-control"
                                                    value="{{ old('demora_motivo', $control->demora_motivo ?? '') }}">
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="form-label">Destino</label>
                                                <input type="text" name="destino" class="form-control"
                                                    value="{{ old('destino', $control->destino ?? '') }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Total pax</label>
                                                <input type="number" min="0" name="total_pax" class="form-control"
                                                    value="{{ old('total_pax', $control->total_pax ?? '') }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Hora real de salida</label>
                                                <input type="time" name="hora_real_salida" class="form-control"
                                                    value="{{ old('hora_real_salida', $control->hora_real_salida ?? '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 4 SEGURIDAD / ADJUNTOS --}}
                                    <div class="tab-pane fade" id="tab-seg">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Agente/Oficial de seguridad (nombre)</label>
                                                <input type="text" name="agente_nombre" class="form-control"
                                                    value="{{ old('agente_nombre', $control->agente_nombre ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ID Agente/Oficial</label>
                                                <input type="text" name="agente_id" class="form-control"
                                                    value="{{ old('agente_id', $control->agente_id ?? '') }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Firma Agente/Oficial</label>
                                                <input type="file" name="agente_firma" class="form-control"
                                                    accept="image/png,image/jpeg,image/webp,image/heic">
                                                @if($control->agente_firma)
                                                <small class="text-muted d-block mt-1">Actual:
                                                    {{ $control->agente_firma }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    {{-- 5 DATOS DE ACCESO --}}
                                    <div class="tab-pane fade " id="tab-acce">
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <label class="form-label">Nombre</label>
                                                <input type="text" name="nombre" class="form-control"
                                                    value="{{ old('nombre', $control->nombre ?? '') }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">Id</label>
                                                <input type="text" name="id" class="form-control"
                                                    value="{{ old('id', $control->id ?? '') }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">hora_entrada</label>
                                                <input type="time" name="hora_entrada" class="form-control"
                                                    value="{{ old('hora_entrada', $control->hora_entrada ?? '') }}">
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="form-label">Hora de salida</label>
                                                <input type="time" name="hora_salida" class="form-control"
                                                    value="{{ old('hora_salida', $control->hora_salida ?? '') }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-label">hora_entrada</label>
                                                <input type="time" name="hora_entrada1" class="form-control"
                                                    value="{{ old('hora_entrada1', $control->hora_entrada1 ?? '') }}">
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="form-label">Hora de salida</label>
                                                <input type="time" name="hora_salida1" class="form-control"
                                                    value="{{ old('hora_salida1', $control->hora_salida1 ?? '') }}">
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="form-label">Herramientas</label>
                                                <input type="text" name="herramientas" class="form-control"
                                                    value="{{ old('herramientas', $control->herramientas ?? '') }}">
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Empresa</label>
                                                <input type="text" name="empresa" class="form-control"
                                                    value="{{ old('empresa', $control->empresa ?? '') }}">
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label">Motivo</label>
                                            <input type="text" name="motivo" class="form-control"
                                                value="{{ old('motivo', $control->motivo ?? '') }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Firma</label>
                                            <input type="file" name="firma" class="form-control"
                                                accept="image/png,image/jpeg,image/webp,image/heic">
                                            @if($control->firma)
                                            <small class="text-muted d-block mt-1">Actual:
                                                {{ $control->firma }}</small>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div><!-- /content -->
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between align-items-center sticky-actions">
                        <small class="text-muted">Revisa cada pestaña antes de guardar.</small>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.controlaeronave.show') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>


@section('content-admin-js')
<script>
$(function() {
    // Por si algún plugin previno el comportamiento por defecto:
    $('a[data-toggle="pill"], a[data-toggle="tab"]').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>
@endsection


@extends('backend.menus.footerjs')
@section('content-admin-js')

@endsection