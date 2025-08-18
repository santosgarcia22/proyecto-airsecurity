<style>
/* COLOR DEL NAVBAR */
.main-header.navbar {
    background: rgb(0, 123, 255) !important;
    border-bottom: none;
    /* Opcional: quita el borde inferior */

    /* Hace que el navbar quede fijo
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    /* alto para que quede sobre todo */
}

/* Para que el contenido no quede tapado por el navbar fijo */

</style>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- <script src="{{ asset('js/alerts.js') }}"></script> -->

<nav class="main-header navbar navbar-expand border-bottom navbar-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: white"><i
                    class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link" style="color: white">{{ $titulo }}</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cogs" style="color: white"></i>
                <span class="hidden-xs" style="color: white"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="{{ route('admin.perfil') }}" target="frameprincipal" class="dropdown-item">
                    <i class="fas fa-user"></i></i> Editar Perfil
                </a>
                <div class="dropdown-divider"></div>

                <a href="{{ route('admin.logout') }}" id="btn-logout" onclick="event.preventDefault();
                    document.getElementById('frm-logout').submit();" class="dropdown-item"> <i
                        class="fas fa-sign-out-alt"></i></i></i> Cerrar Sesión</a>

                <form id="frm-logout" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>



    </ul>
</nav>