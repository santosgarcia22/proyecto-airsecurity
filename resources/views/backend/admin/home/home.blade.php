
@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
.card-home {
    border-left: 3px solid #399bff;
    box-shadow: 0 2px 12px #399bff22;
}
.card-icon-home {
    font-size: 2.5rem;
    color: #399bff;
    margin-right: 5px;
}
.card {
    border-radius: 1.3rem !important;
}
</style>

<section class="content-header">
    <div class="container-fluid">
        <h1 class="mb-1">Bienvenido a AirSecurity</h1>
        <h5 class="text-muted">Sistema integral de control de accesos y seguridad aeroportuaria</h5>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Tarjetas estadísticas -->
        <div class="row mb-4">
            <div class="col-md-3 mb-2">
                <div class="card card-home">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-shield card-icon-home"></i>
                        <div>
                            <h6 class="mb-0">Personal autorizado</h6>
                            <span class="h2">{{ $totalUsuarios ?? '1' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card card-home">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-door-open card-icon-home"></i>
                        <div>
                            <h6 class="mb-0">Accesos hoy</h6>
                            <span class="h2">{{ $accesosHoyCount ?? '1' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-2">
                <div class="card card-home">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-plane card-icon-home"></i>
                        <div>
                            <h6 class="mb-0">Vuelos registrados</h6>
                            <span class="h2">{{ $totalVuelos ?? '1' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3 mb-2">
                <div class="card card-home">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle card-icon-home"></i>
                        <div>
                            <h6 class="mb-0">Alertas activas</h6>
                            <span class="h2">{{ $alertas ?? '0' }}</span>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <!-- Gráficas y mensaje/links -->
        <div class="row mb-4">
            <!-- Gráficas -->
            <div class="col-md-8 mb-4">
                <div class="card mb-4 shadow">
                    <div class="card-header bg-gradient-primary text-white py-2">
                        <h3 class="card-title mb-0" style="font-size:1.15rem;">
                            <i class="fas fa-chart-line"></i> Accesos por Vuelo
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="graficoPorVuelo" height="60"></canvas>
                    </div>
                </div>
                <div class="card mb-2 shadow">
                    <div class="card-header bg-gradient-primary text-white py-2">
                        <h3 class="card-title mb-0" style="font-size:1.15rem;">
                            <i class="fas fa-clock"></i> Accesos por Hora (hoy)
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="graficoPorHora" height="60"></canvas>
                    </div>
                </div>
            </div>
            <!-- Mensaje y accesos rápidos -->
         <div class="col-md-4 d-flex flex-column">
    <div class="card shadow h-100" style="border-radius: 1rem; min-height: 220px;">
        <div class="card-body d-flex flex-column justify-content-start">
            <div>
                <div class="mb-3">
                    <span class="badge bg-gradient-primary mb-2 p-2">¡Hola, {{ Auth::user()->nombre ?? 'Usuario' }}!</span><br>
                    <small class="text-muted">Hoy es {{ \Carbon\Carbon::now()->isoFormat('dddd D [de] MMMM, YYYY') }}</small>
                </div>
                <div class="alert alert-info" style="font-size:1rem; border-radius:1rem;">
                    <b>“La seguridad es un trabajo en equipo. Gracias por ser parte del compromiso AirSecurity.”</b>
                </div>
                <ul class="list-unstyled mt-2">
                    <li class="mb-2"><i class="fas fa-bell text-warning"></i> <span class="text-dark">No olvide revisar las alertas activas.</span></li>
                </ul>
            </div>
            <div>
                <a href="{{ route('admin.accesos.index') }}" class="btn btn-primary mb-2 w-100 rounded-pill shadow-sm">
                    <i class="fas fa-id-badge"></i> Ver todos los accesos
                </a>
                <a href="{{ route('admin.vuelo.index') }}" class="btn btn-outline-primary w-100 rounded-pill shadow-sm">
                    <i class="fas fa-plane"></i> Gestión de vuelos
                </a>
            </div>
        </div>
    </div>
</div>

        </div>
        <!-- Últimos accesos -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Últimos accesos registrados</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Vuelo</th>
                            <th>Posición</th>
                            <th>Sincronización</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accesosRecientes ?? [] as $item)
                        <tr>
                            <td>{{ $item->numero_id }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->tipo }}</td>
                            <td>{{ $item->ingreso }}</td>
                            <td>{{ $item->salida }}</td>
                            <td>{{ $item->numero_vuelo ?? 'QT4010' }}</td>
                            <td>{{ $item->posicion }}</td>
                            <td>{{ $item->Sicronizacion }}</td>
                        </tr>
                        @endforeach
                        @if(empty($accesosRecientes) || count($accesosRecientes) == 0)
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay accesos recientes registrados.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@section('archivos-js')
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Accesos por Vuelo (Line Chart) ---
    var ctxVuelo = document.getElementById('graficoPorVuelo').getContext('2d');
    var chartVuelo = new Chart(ctxVuelo, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelsVuelos) !!},
            datasets: [{
                label: 'Accesos por Vuelo',
                data: {!! json_encode($dataVuelos) !!},
                backgroundColor: 'rgba(33, 150, 243, 0.2)',
                borderColor: 'rgba(33, 150, 243, 1)',
                borderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 8,
                pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            return 'Accesos: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#623ba0ff', font: { weight: 'bold' } },
                    grid: { color: '#c5df2dff' }
                },
                x: {
                    ticks: { color: '#1976d2', font: { weight: 'bold' } },
                    grid: { color: '#e3f2fd' }
                }
            }
        }
    });

    // --- Accesos por Hora (Bar Chart) ---
    var ctxHora = document.getElementById('graficoPorHora').getContext('2d');
    var chartHora = new Chart(ctxHora, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelsHoras) !!},
            datasets: [{
                label: 'Accesos por Hora',
                data: {!! json_encode($dataHoras) !!},
                backgroundColor: 'rgba(0, 191, 255, 0.7)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 2,
                borderRadius: 5,
                hoverBackgroundColor: 'rgba(0, 123, 255, 1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            return 'Accesos: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#1976d2', font: { weight: 'bold' } },
                    grid: { color: '#e3f2fd' }
                },
                x: {
                    ticks: { color: '#1976d2', font: { weight: 'bold' } },
                    grid: { color: '#e3f2fd' }
                }
            }
        }
    });
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


<!-- script de la grafica 
<script>
document.addEventListener('DOMContentLoaded', function() {
    axios.get('/admin/grafico-logins')
        .then(function(response) {
            const labels = response.data.labels;
            const data = response.data.data;

            var ctx = document.getElementById('graficoAccesos').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Inicios de sesión',
                        data: data,
                        backgroundColor: 'rgba(255, 32, 47, 0.6)',
                        borderColor: 'rgba(57, 155, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
});
</script>-->


<script src="{{ asset('js/graficoLogins.js') }}"></script>

@stop