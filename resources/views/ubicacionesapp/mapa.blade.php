@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@stop

<style>
    #map {
        height: 800px;
        width: 100%;
        border-radius: 10px;
    }

    .map-wrapper {
        margin: 20px;
        padding: 10px;
        background: white;
        border-radius: 8px;
    }
</style>

<div id="divcontenedor" style="display: none">
    <div class="map-wrapper">
        <div id="map"></div>
        <div id="ubicaciones-data" data-ubicaciones='@json($ubicaciones)'></div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('archivos-js')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
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

            let rawData = document.getElementById('ubicaciones-data').dataset.ubicaciones;

            try {
                const ubicaciones = JSON.parse(rawData);

                if (!Array.isArray(ubicaciones) || ubicaciones.length === 0) {
                    toastr.info("No hay ubicaciones para mostrar.");
                    return;
                }

                ubicaciones.forEach(ubicacion => {
                    const lat = parseFloat(ubicacion.latitud);
                    const lon = parseFloat(ubicacion.longitud);

                    if (!isNaN(lat) && !isNaN(lon)) {
                        L.marker([lat, lon])
                            .addTo(map)
                            .bindPopup(`
                                <strong>Usuario ID:</strong> ${ubicacion.usuario_id ?? 'N/D'}<br>
                                <strong>Fecha:</strong> ${ubicacion.fecha_hora ?? 'N/D'}
                            `);
                    }
                });

            } catch (e) {
                console.error("Error al procesar las ubicaciones:", e);
                toastr.error("Error al procesar las ubicaciones");
            }
        });
    </script>
@stop
