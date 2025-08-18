@extends('backend.menus.superior')


@section('content-admin')
<style>
    .sticky-actions{position:sticky;bottom:0;background:#fff;border-top:1px solid #e9ecef;padding:.75rem;z-index:10}
    .nav-pills .nav-link{border-radius:.5rem}
    .tab-pane{padding-top:.5rem}
</style>

<div class="row g-3">
    <div class="col-lg-3">
        <div class="nav flex-lg-column nav-pills gap-2" role="tablist">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-base" type="button">1. Datos base</button>
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-procesos" type="button">2. Procesos / tiempos</button>
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-demoras" type="button">3. Demoras y pax</button>
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-seg" type="button">4. Seguridad / adjuntos</button>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="tab-content">
            {{-- 1) DATOS BASE --}}
            <div class="tab-pane fade show active" id="tab-base">
                <div class="row g-3">
                    <div class="col-sm-4">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha"
                               value="{{ old('fecha', isset($control) ? $control->fecha : '') }}"
                               class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Origen</label>
                        <input type="text" name="origen"
                               value="{{ old('origen', isset($control) ? $control->origen : '') }}"
                               class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">N.º de vuelo</label>
                        <input type="text" name="numero_vuelo"
                               value="{{ old('numero_vuelo', isset($control) ? $control->numero_vuelo : '') }}"
                               class="form-control" required>
                    </div>

                    <div class="col-sm-4">
                        <label class="form-label">Hora de llegada</label>
                        <input type="time" name="hora_llegada"
                               value="{{ old('hora_llegada', isset($control) ? $control->hora_llegada : '') }}"
                               class="form-control">
                    </div>
                    <div class="col-sm-8">
                        <label class="form-label">Posición de llegada</label>
                        <input type="text" name="posicion_llegada"
                               value="{{ old('posicion_llegada', isset($control) ? $control->posicion_llegada : '') }}"
                               class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Matrícula y operador</label>
                        <input type="text" name="matricula_operador"
                               value="{{ old('matricula_operador', isset($control) ? $control->matricula_operador : '') }}"
                               class="form-control" placeholder="Ej.: N123AB / AV GUG">
                    </div>

                    <div class="col-sm-6">
                        <label class="form-label">Coordinador / Líder de vuelo</label>
                        <input type="text" name="coordinador_lider"
                               value="{{ old('coordinador_lider', isset($control) ? $control->coordinador_lider : '') }}"
                               class="form-control">
                    </div>
                </div>
            </div>

            {{-- 2) PROCESOS / TIEMPOS --}}
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
                                       value="{{ old('desabordaje_inicio', isset($control) ? $control->desabordaje_inicio : '') }}"
                                       class="form-control"></td>
                            <td><input type="time" name="desabordaje_fin"
                                       value="{{ old('desabordaje_fin', isset($control) ? $control->desabordaje_fin : '') }}"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Inspección cabina</td>
                            <td><input type="time" name="inspeccion_cabina_inicio"
                                       value="{{ old('inspeccion_cabina_inicio', isset($control) ? $control->inspeccion_cabina_inicio : '') }}"
                                       class="form-control"></td>
                            <td><input type="time" name="inspeccion_cabina_fin"
                                       value="{{ old('inspeccion_cabina_fin', isset($control) ? $control->inspeccion_cabina_fin : '') }}"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Aseo (personal)</td>
                            <td><input type="time" name="aseo_ingreso"
                                       value="{{ old('aseo_ingreso', isset($control) ? $control->aseo_ingreso : '') }}"
                                       class="form-control" placeholder="Ingreso"></td>
                            <td><input type="time" name="aseo_salida"
                                       value="{{ old('aseo_salida', isset($control) ? $control->aseo_salida : '') }}"
                                       class="form-control" placeholder="Salida"></td>
                        </tr>
                        <tr>
                            <td>Tripulación</td>
                            <td><input type="time" name="tripulacion_ingreso"
                                       value="{{ old('tripulacion_ingreso', isset($control) ? $control->tripulacion_ingreso : '') }}"
                                       class="form-control" placeholder="Ingreso"></td>
                            <td><input type="time" name="salida_itinerario"
                                       value="{{ old('salida_itinerario', isset($control) ? $control->salida_itinerario : '') }}"
                                       class="form-control" placeholder="Salida itinerario"></td>
                        </tr>
                        <tr>
                            <td>Abordaje</td>
                            <td><input type="time" name="abordaje_inicio"
                                       value="{{ old('abordaje_inicio', isset($control) ? $control->abordaje_inicio : '') }}"
                                       class="form-control"></td>
                            <td><input type="time" name="abordaje_fin"
                                       value="{{ old('abordaje_fin', isset($control) ? $control->abordaje_fin : '') }}"
                                       class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Cierre de puertas</td>
                            <td><input type="time" name="cierre_puertas"
                                       value="{{ old('cierre_puertas', isset($control) ? $control->cierre_puertas : '') }}"
                                       class="form-control"></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 3) DEMORAS Y PAX --}}
            <div class="tab-pane fade" id="tab-demoras">
                <div class="row g-3">
                    <div class="col-sm-3">
                        <label class="form-label">Demora (min)</label>
                        <input type="number" min="0" name="demora_tiempo"
                               value="{{ old('demora_tiempo', isset($control) ? $control->demora_tiempo : '') }}"
                               class="form-control">
                    </div>
                    <div class="col-sm-9">
                        <label class="form-label">Motivo de demora</label>
                        <input type="text" name="demora_motivo"
                               value="{{ old('demora_motivo', isset($control) ? $control->demora_motivo : '') }}"
                               class="form-control">
                    </div>

                    <div class="col-sm-4">
                        <label class="form-label">Destino</label>
                        <input type="text" name="destino"
                               value="{{ old('destino', isset($control) ? $control->destino : '') }}"
                               class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Total pax</label>
                        <input type="number" min="0" name="total_pax"
                               value="{{ old('total_pax', isset($control) ? $control->total_pax : '') }}"
                               class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Hora real de salida</label>
                        <input type="time" name="hora_real_salida"
                               value="{{ old('hora_real_salida', isset($control) ? $control->hora_real_salida : '') }}"
                               class="form-control">
                    </div>
                </div>
            </div>

            {{-- 4) SEGURIDAD / ADJUNTOS --}}
            <div class="tab-pane fade" id="tab-seg">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Agente/Oficial de seguridad (nombre)</label>
                        <input type="text" name="agente_nombre"
                               value="{{ old('agente_nombre', isset($control) ? $control->agente_nombre : '') }}"
                               class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">ID Agente/Oficial</label>
                        <input type="text" name="agente_id"
                               value="{{ old('agente_id', isset($control) ? $control->agente_id : '') }}"
                               class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Firma Agente/Oficial</label>
                        <input type="file" name="agente_firma" class="form-control"
                               accept="image/png,image/jpeg,image/webp,image/heic">
                        @if(isset($control) && $control->agente_firma)
                            <small class="text-muted d-block mt-1">Actual: {{ $control->agente_firma }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('backend.menus.footerjs')
@section('content-admin-js')
<script>
function delItem(id){
    if(!confirm('¿Eliminar registro?')) return;
    fetch(`{{ url('admin/controlaeronave') }}/${id}`, {
        method:'DELETE',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
    }).then(r=>r.json()).then(j=>{
        if(j.res){ location.reload(); }
    });
}
</script>
@endsection