<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Panel</title>

    <link href="{{ asset('images/Airsecurity.png') }}" rel="icon">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link href="{{ asset('fontawesome-free/css/all.min.css') }}" type="text/css" rel="stylesheet" />
    <!-- Theme style -->
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <!-- Mensajes Toast -->
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    @yield('content-admin-css')
</head>

<!-- para iniciar con el menu cerrado colocar
 <body class="sidebar-mini sidebar-closed sidebar-collapse" style="height: auto;">
 -->

<body class="sidebar-mini sidebar-closed sidebar-collapse" style="height: auto;">
    <div class="wrapper">
        @include("backend.menus.navbar")
        @include("backend.menus.sidebar")

        <div id="iframe-loader"
            style="position:absolute;top:0;left:0;width:100%;height:100%;background:#fff;z-index:10;text-align:center;padding:20px;">
            Cargando...
        </div>

        <div class="content-wrapper" style=" background-color: #fff;">
            <!-- redireccionamiento de vista -->

            <iframe style="width: 100%; resize: initial; overflow: hidden; min-height: 96vh" frameborder="0"
                scrolling="" id="frameprincipal" src="" name="frameprincipal">
            </iframe>

        </div>

        @include("backend.menus.footer")

    </div>


    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/adminlte.min.js') }}" type="text/javascript"></script>


    @yield('content-admin-js')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const iframe = document.getElementById('frameprincipal');
        const loader = document.getElementById('iframe-loader');
        const storedUrl = localStorage.getItem('iframeUrl');
        if (storedUrl) {
            iframe.src = storedUrl;
        } else {
            iframe.src = "{{ route($ruta) }}";
        }
        iframe.onload = function() {
            loader.style.display = 'none';
        };
    });
    </script>

    <script>
    function guardarUltimaVista(event, url) {
        // Guardar la URL de la vista en localStorage
        localStorage.setItem('ultimaVista', url);
    }

    // Al cargar la página, verifica si hay una vista guardada
    document.addEventListener('DOMContentLoaded', function() {
        var iframe = document.getElementById('frameprincipal');
        var ultimaVista = localStorage.getItem('ultimaVista');
        if (iframe && ultimaVista) {
            iframe.src = ultimaVista;
        }
    });
    </script>
 <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/alerts.js') }}"></script>

@include('components.chatbot-widget')

</body>

</html>