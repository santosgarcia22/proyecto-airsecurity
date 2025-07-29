@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@stop

<style>
    #map {
        height: 600px;
        width: 100%;
    }
</style>

<div id="divcontenedor" style="display: none">
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Mapa de Ubicaciones</h4>
            </div>
            <div class="card-body">
                <div id="map"></div>
                <div id="ubicaciones-data" data-ubicaciones="{{ htmlspecialchars(json_encode($ubicaciones), ENT_QUOTES, 'UTF-8') }}"></div>
            </div>
        </div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('archivos-js')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("divcontenedor").style.display = "block";

            const map = L.map('map').setView([13.6929, -89.2182], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            const rawData = document.getElementById('ubicaciones-data').dataset.ubicaciones;
            const ubicaciones = JSON.parse(rawData);

            ubicaciones.forEach(ubicacion => {
                L.marker([ubicacion.latitud, ubicacion.longitud])
                    .addTo(map)
                    .bindPopup(`Usuario ID: ${ubicacion.usuario_id ?? 'N/D'}<br>Fecha: ${ubicacion.fecha_hora}`);
            });
        });
    </script>
@stop
