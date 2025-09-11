<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel de Administración')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- AdminLTE + librerías -->
    <link rel="preload" href="{{ asset('css/adminlte.min.css') }}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    </noscript>

    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />

    <!-- Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />


    <link href="{{ asset('fontawesome-free/css/all.min.css') }}" rel="stylesheet" />

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- 🔹 Estilos específicos de cada vista -->
    <style>
    /* Cortina anti-FOUC: oculta sin colapsar el layout */
    .no-fouc {
        visibility: hidden;
    }
    </style>
    @yield('content-admin-css')


    <script type="text/javascript">
    var url = "/admin";
    </script>
</head>

<body class="hold-transition sidebar-mini">