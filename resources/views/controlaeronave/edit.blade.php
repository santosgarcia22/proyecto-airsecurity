@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
table {
    table-layout: fixed;
}

.sticky-actions {
    position: sticky;
    bottom: 0;
    background: #fff;
    border-top: 1px solid #e9ecef;
    padding: .75rem;
    z-index: 10;
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
                <h4 class="mb-0">Control acceso aeronave - Editar</h4>
            </div>

            <form action="{{ route('admin.controlaeronave.update', $vuelo->id) }}" method="POST">
                @csrf
                @method('PUT')


                <div class="card-body">
                    <div class="row g-3">

                        <!-- Tabs -->
                        <div class="col-lg-3">
                            <div class="nav flex-lg-column nav-pills gap-2" role="tablist">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-procesos"
                                    type="button">1. Tiempos Operativos</button>
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-demoras"
                                    type="button">2. Demoras y pax</button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="col-lg-9">
                            <div class="tab-content">

                                {{-- 1 TIEMPOS OPERATIVOS --}}
                                <div id="tab-procesos" class="tab-pane fade show active">
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
                                                    <td><input type="time" name="tiempos[desabordaje_inicio]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.desabordaje_inicio', optional($tiempos)->desabordaje_inicio) }}"
                                                            required></td>
                                                    <td><input type="time" name="tiempos[desabordaje_fin]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.desabordaje_fin', optional($tiempos)->desabordaje_fin) }}"
                                                            required></td>
                                                </tr>
                                                <tr>
                                                    <td>Inspección cabina</td>
                                                    <td><input type="time" name="tiempos[inspeccion_cabina_inicio]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.inspeccion_cabina_inicio', optional($tiempos)->inspeccion_cabina_inicio) }}"
                                                            required></td>
                                                    <td><input type="time" name="tiempos[inspeccion_cabina_fin]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.inspeccion_cabina_fin', optional($tiempos)->inspeccion_cabina_fin) }}"
                                                            required></td>
                                                </tr>
                                                <tr>
                                                    <td>Aseo (personal)</td>


                                                    <td><input type="time" name="tiempos[aseo_ingreso]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.aseo_ingreso', optional($tiempos)->aseo_ingreso) }}"
                                                            required></td>

                                                    <td><input type="time" name="tiempos[aseo_salida]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.aseo_salida', optional($tiempos)->aseo_salida) }}"
                                                            required></td>


                                                </tr>
                                                <tr>
                                                    <td>Tripulación</td>

                                                    <td><input type="time" name="tiempos[tripulacion_ingreso]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.tripulacion_ingreso', optional($tiempos)->tripulacion_ingreso) }}"
                                                            required></td>



                                                </tr>
                                                <tr>
                                                    <td>Abordaje</td>


                                                    <td><input type="time" name="tiempos[abordaje_inicio]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.abordaje_inicio', optional($tiempos)->abordaje_inicio) }}"
                                                            required></td>

                                                    <td><input type="time" name="tiempos[abordaje_fin]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.abordaje_fin', optional($tiempos)->abordaje_fin) }}"
                                                            required></td>
                                                </tr>
                                                <tr>
                                                    <td>Cierre de puerta</td>

                                                    <td><input type="time" name="tiempos[cierre_puerta]"
                                                            class="form-control"
                                                            value="{{ old('tiempos.cierre_puerta', optional($tiempos)->cierre_puerta) }}"
                                                            required></td>



                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 2 DEMORAS --}}
                                <div id="tab-demoras" class="tab-pane fade">
                                    <div class="row g-3">
                                        <div class="col-sm-3">
                                            <label class="form-label">Tiempo (min)</label>
                                            <input type="number" min="0" step="1" name="demoras[minutos]"
                                                class="form-control"
                                                value="{{ old('demoras.minutos', optional($demoras)->minutos) }}"
                                                required>
                                        </div>
                                        <div class="col-sm-9">
                                            <label class="form-label">Motivo de demora</label>
                                            <input type="text" name="demoras[motivo]" maxlength="200"
                                                class="form-control"
                                                value="{{ old('demoras.motivo', optional($demoras)->motivo) }}"
                                                required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">Agente ID</label>
                                            <input type="number" name="demoras[agente_id]" min="1" step="1"
                                                class="form-control"
                                                value="{{ old('demoras.agente_id', optional($demoras)->agente_id) }}"
                                                required>

                                        </div>
                                    </div>
                                </div>

                            </div><!-- /content -->
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <a class="btn btn-secondary" href="{{ route('admin.controlaeronave.index') }}">Cancelar</a>
                        <div>
                            <button type="button" class="btn btn-outline-secondary" id="btnPrev">Anterior</button>
                            <button type="button" class="btn btn-primary" id="btnNext">Siguiente</button>
                            <button type="submit" class="btn btn-success d-none" id="btnSave">Guardar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>


@extends('backend.menus.footerjs')
@section('archivos-js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const navButtons = Array.from(document.querySelectorAll('[data-bs-toggle="pill"]'));
    const panes = Array.from(document.querySelectorAll('.tab-pane'));
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const btnSave = document.getElementById('btnSave');
    let i = 0;

    function show(idx) {
        // activa/desactiva botones
        navButtons.forEach((b, k) => {
            b.classList.toggle('active', k === idx);
            b.setAttribute('aria-selected', k === idx ? 'true' : 'false');
        });

        // muestra contenido
        panes.forEach((p, k) => {
            p.classList.toggle('show', k === idx);
            p.classList.toggle('active', k === idx);
        });

        // controla visibilidad de botones
        btnPrev.disabled = (idx === 0);
        btnNext.classList.toggle('d-none', idx === navButtons.length - 1);
        btnSave.classList.toggle('d-none', idx !== navButtons.length - 1);
    }

    // cuando hago click en tab manualmente
    navButtons.forEach((b, idx) => b.addEventListener('click', e => {
        e.preventDefault();
        i = idx;
        show(i);
    }));

    // siguiente
    btnNext.addEventListener('click', () => {
        if (i < navButtons.length - 1) {
            i++;
            show(i);
        }
    });

    // anterior
    btnPrev.addEventListener('click', () => {
        if (i > 0) {
            i--;
            show(i);
        }
    });

    // mostrar la primera pestaña al cargar
    show(0);
});
</script>
@endsection