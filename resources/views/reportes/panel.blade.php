<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Reportes</title>
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <style>
        .card {
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 10px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        .card-body {
            padding: 30px 20px;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .card-text {
            font-size: 0.95rem;
        }

        .titulo-panel {
            font-size: 1.8rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h3 class="text-center titulo-panel">Panel de Reportes</h3>

    <div class="row mt-4">

        <!-- Accesos -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary" onclick="location.href='{{ route('reportes.accesos') ?? '#' }}'">
                <div class="card-body text-center">
                    <h5 class="card-title">Reporte de Accesos</h5>
                    <p class="card-text">Filtrado por fechas, ingreso/salida y más.</p>
                </div>
            </div>
        </div>

        <!-- Tipos -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info" onclick="location.href='{{ route('reportes.tipos') ?? '#' }}'">
                <div class="card-body text-center">
                    <h5 class="card-title">Reporte de Tipos</h5>
                    <p class="card-text">Resumen y control por tipo de usuario o acceso.</p>
                </div>
            </div>
        </div>

        <!-- Vuelos -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning" onclick="location.href='{{ route('reportes.vuelos') ?? '#' }}'">
                <div class="card-body text-center">
                    <h5 class="card-title">Reporte de Vuelos</h5>
                    <p class="card-text">Visualiza vuelos, horarios y conexiones.</p>
                </div>
            </div>
        </div>

        <!-- Ubicaciones -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-secondary" onclick="location.href='{{ route('reportes.ubicaciones') ?? '#' }}'">
                <div class="card-body text-center">
                    <h5 class="card-title">Reporte de Ubicaciones</h5>
                    <p class="card-text">Ubicación geográfica de ingresos y movimientos.</p>
                </div>
            </div>
        </div>

        <!-- Usuarios App -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success" onclick="location.href='{{ route('reportes.usuariosapp') ?? '#' }}'">
                <div class="card-body text-center">
                    <h5 class="card-title">Reporte de Usuarios App</h5>
                    <p class="card-text">Consulta de registros desde aplicación móvil.</p>
                </div>
            </div>
        </div>

        <!-- Otros (placeholder para crecer) -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-dark" onclick="location.href='#'">
                <div class="card-body text-center">
                    <h5 class="card-title">Otro Reporte</h5>
                    <p class="card-text">Espacio para futuros módulos de reporte.</p>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
