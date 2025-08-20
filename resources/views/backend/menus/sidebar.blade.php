<style>
/* Por defecto, solo logo completo */
.logo-mini {
    display: none !important;
}

.logo-full {
    display: inline !important;
}

/* Cuando sidebar está colapsado (cerrado del todo) */
.sidebar-mini.sidebar-collapse .logo-mini {
    display: inline !important;
}

.sidebar-mini.sidebar-collapse .logo-full,
.sidebar-mini.sidebar-collapse .brand-text {
    display: none !important;
}

/* Cuando sidebar colapsado está en hover o expandido temporalmente */
.sidebar-mini.sidebar-collapse.sidebar-open .logo-mini,
.sidebar-mini.sidebar-collapse.sidebar-open .brand-text {
    display: none !important;
}

.sidebar-mini.sidebar-collapse.sidebar-open .logo-full {
    display: inline !important;
}

/* Para AdminLTE v3 y algunos casos en hover */
.sidebar-mini.sidebar-collapse .main-sidebar:hover .logo-full,
.sidebar-mini.sidebar-collapse .main-sidebar:focus .logo-full {
    display: inline !important;
}

.sidebar-mini.sidebar-collapse .main-sidebar:hover .logo-mini,
.sidebar-mini.sidebar-collapse .main-sidebar:focus .logo-mini {
    display: none !important;
}

.sidebar-mini.sidebar-collapse .main-sidebar:hover .brand-text,
.sidebar-mini.sidebar-collapse .main-sidebar:focus .brand-text {
    display: inline !important;
}

.main-sidebar {
    background: rgba(rgba(61, 70, 77, 1)) !important;
    /* o prueba con #f4f6f9 */
    border-right: 1px solid #e3e6ec;
    /* Opcional, para darle separación */
}

.brand-link img {
    /*  background: #e3e6ec;       Fondo blanco */
    border-radius: 14px;
    /* Bordes redondeados */
    padding: 6px;
    /* Espacio interno */
    box-shadow: 0 10px 10px #0002;
    /*Sombra suave opcional */
}

/* Cambiar color del texto de todo el sidebar */
.main-sidebar,
.sidebar {
    color: rgb(226, 229, 233);
}

.main-sidebar .nav-link,
.sidebar .nav-link {
    color: rgb(236, 242, 248) !important;
}

.main-sidebar .nav-link:hover,
.sidebar .nav-link:hover {
    color: rgb(244, 111, 113) !important;
}

.aside {
    height: 100%;
}



/* Ajustar el sidebar para que empiece debajo del navbar fijo
.main-sidebar {
    position: fixed; /* asegura que también sea fijo 
    top: 56px;       /* mismo alto que el navbar 
    height: calc(100% - 56px); /* ocupa todo el alto restante 
}

.content-wrapper {
    margin-top: 56px;  para que el contenido no se solape con el navbar 
}
*/
</style>
<!-- en la clase elevation-0 es para ponerle una especie de sobra al la imagen -->




<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.home') }}" target="frameprincipal"
        class="brand-link d-flex align-items-center justify-content-center">
        <img src="{{ asset('images/image.png') }}" alt="Logo" class="brand-image elevation-0 logo-full"
            style="transition: all 0.2s; max-height:32px;">
        <img src="{{ asset('images/icon.png') }}" alt="Logo" class="brand-image elevation-1 logo-mini"
            style="display:none; transition: all 0.2s; max-height:32px;">
    </a>

    <span class="brand-text font-weight" style="color: white; margin-left: 10px;">PANEL DE CONTROL</span>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">

                @can('sidebar.roles.y.permisos')

                <li class="nav-item">
                    <a href="#" class="nav-link nav-">
                        <i class="fas fa-tag"></i> <!-- Ícono de etiqueta (tag) -->

                        <p>
                            tipo
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.tipo.index') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tipo</p>
                            </a>
                        </li>
                    </ul>
                </li>



                @endcan

                @can('sidebar.roles.y.permisos')
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link nav-">
                        <i class="fas fa-plane-departure"></i> <!-- icono sólido de avión 
                        <p>
                            Vuelos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.vuelo.index') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vuelo</p>
                            </a>
                        </li>
                    </ul>
                </li> -->


                <li class="nav-item">
                    <a href="#" class="nav-link nav-">
                        <i class="fas fa-plane-departure"></i> <!-- icono sólido de avión -->
                        <p>
                            Vuelos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.vuelo.index') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Vuelo</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <!-- CONTROL DE ACCESO -->
                @can('sidebar.roles.y.permisos')
                <li class="nav-item">
                    <a href="#" class="nav-link nav-">
                        <i class="fas fa-door-open"></i> <!-- icono sólido, puerta abierta para acceso -->
                        <p>
                            Control de Acceso
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.accesos.index') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i> Acceso Aeronave/Diamante
                            </a>

                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.controlaeronave.index') }}" target="frameprincipal"
                                class="nav-link" onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i> control Acceso Aeronave
                            </a>

                        </li>
                    </ul>
                </li>
                @endcan

                <!-- CONTROL DE ACCESO -->
                @can('sidebar.roles.y.permisos')
                <li class="nav-item">
                    <a href="#" class="nav-link nav-">
                        <i class="fas fa-door-open"></i> <!-- icono sólido, puerta abierta para acceso -->
                        <p>
                            Geolozalización
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ubicaciones.mapa') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i> Mapa
                            </a>

                        </li>
                    </ul>
                </li>
                @endcan

                <!-- ROLES Y PERMISO -->
                @can('sidebar.roles.y.permisos')
                <li class="nav-item">
                    <a href="#" class="nav-link nav-">
                        <i class="fas fa-user-shield"></i> <!-- icono sólido similar a seguridad -->
                        <p>
                            Roles y Permisos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rol y Permisos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.permisos.index') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.usuariosapp.index') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuario App</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reportes.panel') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reportes</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan

                <!-- REPORTES -->
                @can('sidebar.roles.y.permisos')
                <li class="nav-item">
                    <a href="#" class="nav-link nav-">
                        <i class="fas fa-chart-line"></i> <!-- icono de reportes/estadísticas -->
                        <p>
                            Reportes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('reportes.panel') }}" target="frameprincipal" class="nav-link"
                                onclick="guardarUltimaVista(event, this.href)">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Panel de Reportes</p>
                            </a>
                        </li>
                        <!-- Si en un futuro tienes más reportes, puedes agregarlos aquí -->
                        {{-- 
                        <li class="nav-item">
                        <a href="{{ route('reportes.otro') }}" target="frameprincipal" class="nav-link"
                        onclick="guardarUltimaVista(event, this.href)">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Otro Reporte</p>
                        </a>
                </li>
                --}}
            </ul>
            </li>
            @endcan

            <!-- VUELOS -->

            </ul>
        </nav>
    </div>

</aside>