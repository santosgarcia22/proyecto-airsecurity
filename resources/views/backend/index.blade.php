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

    <!-- 🔹 Preloader -->
    <div id="global-preloader" style="position:fixed;top:0;left:0;width:100%;height:100%;
            background:#fff;z-index:9999;display:flex;
            align-items:center;justify-content:center;
            transition: opacity 0.4s ease, visibility 0.4s ease;
            opacity:1; visibility:visible;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
    </div>
    <div class="wrapper">
        @include("backend.menus.navbar")
        @include("backend.menus.sidebar")

        <div class="content-wrapper" style=" background-color: #fff;">
            <!-- redireccionamiento de vista -->
            <iframe style="width: 100%; resize: initial; overflow: hidden; min-height: 96vh" frameborder="0"
                id="frameprincipal" name="frameprincipal"></iframe>
        </div>

        @include("backend.menus.footer")
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    @yield('content-admin-js')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const iframe = document.getElementById('frameprincipal');
        const preloader = document.getElementById('global-preloader');

        // 🔹 Generar clave única por usuario (ej: user_5 o admin_1)
        const userKey = "lastIframeUrl_" + "{{ Auth::user()->id }}";

        function hidePreloader() {
            preloader.style.opacity = "0";
            preloader.style.visibility = "hidden";
            setTimeout(() => preloader.style.display = "none", 500);
        }

        function showPreloader() {
            preloader.style.display = "flex";
            preloader.style.opacity = "1";
            preloader.style.visibility = "visible";
        }

        // 🔹 Recuperar última URL de este usuario
        const lastUrl = localStorage.getItem(userKey);
        if (lastUrl) {
            iframe.src = lastUrl;
        } else {
            iframe.src = "/admin/home"; // o la ruta inicial según rol
        }

        // 🔹 Guardar URL al cargar iframe
        iframe.addEventListener("load", () => {
            hidePreloader();
            try {
                localStorage.setItem(userKey, iframe.contentWindow.location.href);
            } catch (e) {
                console.warn("No se pudo guardar la URL del iframe:", e);
            }
        });

        // 🔹 Guardar URL al dar clic en el menú
        document.querySelectorAll('.nav-link[target="frameprincipal"]').forEach(link => {
            link.addEventListener("click", () => {
                const url = link.getAttribute("href");
                if (url) {
                    localStorage.setItem(userKey, url);
                }
                showPreloader();
                setTimeout(hidePreloader, 5000);
            });
        });
    });
    </script>



</body>


</html>