<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Reportes</title>
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background: #f5f6fa;
    }

    .titulo-panel {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .card {
        cursor: pointer;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border-radius: 15px;
        border: none;
    }

    .card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .card-body {
        padding: 35px 20px;
    }

    .card-title {
        font-size: 1.3rem;
        margin-top: 10px;
        font-weight: bold;
    }

    .card-text {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .icono {
        font-size: 2.5rem;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h3 class="text-center titulo-panel mb-4">
            <i class="bi bi-graph-up-arrow"></i> Panel de Reportes
        </h3>

        <div class="row g-4">

            <!-- Accesos -->
            <div class="col-md-4">
                <div class="card bg-primary text-white text-center"
                    onclick="location.href='{{ route('reportes.accesos') ?? '#' }}'">
                    <div class="card-body">
                        <i class="bi bi-door-open-fill icono"></i>
                        <h5 class="card-title">Accesos</h5>
                        <p class="card-text">Filtrado por fechas, ingreso/salida y más.</p>
                    </div>
                </div>
            </div>

            <!-- Tipos -->
            <div class="col-md-4">
                <div class="card bg-info text-white text-center"
                    onclick="location.href='{{ route('reportes.tipos') ?? '#' }}'">
                    <div class="card-body">
                        <i class="bi bi-people-fill icono"></i>
                        <h5 class="card-title">Tipos</h5>
                        <p class="card-text">Resumen y control por tipo de usuario o acceso.</p>
                    </div>
                </div>
            </div>

            <!-- Vuelos -->
            <div class="col-md-4">
                <div class="card bg-warning text-dark text-center"
                    onclick="location.href='{{ route('reportes.vuelos') ?? '#' }}'">
                    <div class="card-body">
                        <i class="bi bi-airplane-fill icono"></i>
                        <h5 class="card-title">Vuelos</h5>
                        <p class="card-text">Visualiza vuelos, horarios y conexiones.</p>
                    </div>
                </div>
            </div>

            <!-- Ubicaciones -->
            <div class="col-md-4">
                <div class="card bg-secondary text-white text-center"
                    onclick="location.href='{{ route('reportes.ubicaciones') ?? '#' }}'">
                    <div class="card-body">
                        <i class="bi bi-geo-alt-fill icono"></i>
                        <h5 class="card-title">Ubicaciones</h5>
                        <p class="card-text">Ubicación geográfica de ingresos y movimientos.</p>
                    </div>
                </div>
            </div>

            <!-- Usuarios App -->
            <div class="col-md-4">
                <div class="card bg-success text-white text-center"
                    onclick="location.href='{{ route('reportes.usuariosapp') ?? '#' }}'">
                    <div class="card-body">
                        <i class="bi bi-phone-fill icono"></i>
                        <h5 class="card-title">Usuarios App</h5>
                        <p class="card-text">Consulta de registros desde aplicación móvil.</p>
                    </div>
                </div>
            </div>

            <!-- Control Aeronave -->
            <div class="col-md-4">
                <div class="card bg-danger text-white text-center"
                    onclick="location.href='{{ route('reportes.control_aeronave.index') }}'">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-spreadsheet-fill icono"></i>
                        <h5 class="card-title">Control Aeronave</h5>
                        <p class="card-text">Filtrar y exportar planilla del vuelo.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>