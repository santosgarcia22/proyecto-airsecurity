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

                            {{-- Dentro del <form> ... --}}

                            @if(optional($vuelo)->id)
                            {{-- Si llegaste con ?vuelo_id=xxx, mandamos ese id fijo --}}
                            <input type="hidden" name="vuelo_id" value="{{ $vuelo->id }}">
                            @else
                            {{-- Si no, muestra un select (y SOLO el select) --}}
                            <div class="mb-3">
                                <label class="form-label">Selecciona vuelo</label>
                                <select name="vuelo_id" class="form-control" required>
                                    <option value="" selected disabled>-- Selecciona --</option>
                                    @foreach(\App\Models\vuelo::orderByDesc('id')->limit(50)->get() as $v)
                                    <option value="{{ $v->id }}" {{ old('vuelo_id') == $v->id ? 'selected' : '' }}>
                                        {{ $v->fecha }} —
                                        {{ $v->numero_vuelo_llegando ?? $v->numero_vuelo_saliendo ?? 'N/A' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif


                            <!-- Tabs -->
                            <div class="col-lg-3">
                                <div class="nav flex-lg-column nav-pills gap-2" role="tablist">

                                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-procesos"
                                        type="button">1. Tiempos Operativos </button>

                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-demoras"
                                        type="button">2. Demoras y pax </button>
                                    <!-- <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-seg"
                                        type="button">3. Operadores </button> -->
                                    <!-- <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-acce"
                                        type="button">5. Datos de accesos Y QUITAR TAMBIEN YA ESTA EN EL MODAL</button> -->
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
                                                                class="form-control" required></td>
                                                        <td><input type="time" name="tiempos[desabordaje_fin]"
                                                                class="form-control" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Inspección cabina</td>
                                                        <td><input type="time" name="tiempos[inspeccion_cabina_inicio]"
                                                                class="form-control" required></td>
                                                        <td><input type="time" name="tiempos[inspeccion_cabina_fin]"
                                                                class="form-control" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Aseo (personal)</td>
                                                        <td><input type="time" name="tiempos[aseo_ingreso]"
                                                                class="form-control" required></td>
                                                        <td><input type="time" name="tiempos[aseo_salida]"
                                                                class="form-control" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tripulación</td>
                                                        <td><input type="time" name="tiempos[tripulacion_ingreso]"
                                                                class="form-control" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Abordaje</td>
                                                        <td><input type="time" name="tiempos[abordaje_inicio]"
                                                                class="form-control" required></td>
                                                        <td><input type="time" name="tiempos[abordaje_fin]"
                                                                class="form-control" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cierre de puerta</td>
                                                        <td><input type="time" name="tiempos[cierre_puerta]"
                                                                class="form-control" required></td>
                                                        <td></td>
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
                                                <input type="number" min="0" step="1" name="demoras[minutos]" min="0"
                                                    step="1" class="form-control" required>
                                            </div>
                                            <div class="col-sm-9">
                                                <label class="form-label">Motivo de demora</label>
                                                <input type="text" name="demoras[motivo]" maxlength="200"
                                                    class="form-control" required>
                                            </div>

                                            <div class="col-sm-4">
                                                <label class="form-label">Agente ID</label>
                                                <input type="number" name="demoras[agente_id]" min="1" step="1"
                                                    class="form-control" required>
                                            </div>

                                        </div>
                                    </div>

                                </div><!-- /content -->
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <small class="text-muted">Revisa cada pestaña antes de guardar.</small>
                              <a class="btn btn-secondary" href="{{ route('admin.controlaeronave.index') }}">Cancelar</a>
                            <button type="button" class="btn btn-outline-secondary" id="btnPrev">Anterior</button>
                            <div>
                                <button type="button" class="btn btn-primary" id="btnNext">Siguiente</button>
                                <button type="submit" class="btn btn-success d-none" id="btnSave">Guardar</button>
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
        const navButtons = Array.from(document.querySelectorAll('[data-bs-toggle="pill"]'));
        const panes = Array.from(document.querySelectorAll('.tab-pane'));
        const btnPrev = document.getElementById('btnPrev');
        const btnSave = document.getElementById('btnSave');
        let i = 0;

        function show(idx) {
            navButtons.forEach((b, k) => {
                b.classList.toggle('active', k === idx);
                b.setAttribute('aria-selected', k === idx ? 'true' : 'false');
            });
            panes.forEach((p, k) => {
                p.classList.toggle('show', k === idx);
                p.classList.toggle('active', k === idx);
            });
            btnPrev.disabled = (idx === 0);
            btnNext.classList.toggle('d-none', idx === navButtons.length - 1);
            btnSave.classList.toggle('d-none', idx !== navButtons.length - 1);
        }

        navButtons.forEach((b, idx) => b.addEventListener('click', e => {
            e.preventDefault();
            i = idx;
            show(i);
        }));
        btnNext.addEventListener('click', () => {
            if (i < navButtons.length - 1) {
                i++;
                show(i);
            }
        });
        btnPrev.addEventListener('click', () => {
            if (i > 0) {
                i--;
                show(i);
            }
        });
        show(0);
    });
    </script>

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


    @stop