<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Login\LoginController;
use App\Http\Controllers\Controles\ControlController;
use App\Http\Controllers\Backend\Roles\RolesController;
use App\Http\Controllers\Backend\Roles\PermisoController;
use App\Http\Controllers\Backend\Perfil\PerfilController;
use App\Http\Controllers\Backend\Configuracion\ConfiguracionController;
use App\Http\Controllers\Backend\Registro\RegistroController;
use App\Http\Controllers\Frontend\AccesoController;
use App\Http\Controllers\AccesoFrontendController;
use App\Http\Controllers\VueloFrontendController;
use App\Http\Controllers\tipoController;
use App\Http\Controllers\UsuarioAppController;
use App\Http\Controllers\ChatFlowController;
use App\Http\Controllers\UbicacionFrontendController;
use App\Http\Controllers\Backend\Dashboard\DashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\api\AccesoApiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ControlAeronaveController;
use App\Http\Controllers\accesos_personalController;
use App\Http\Controllers\VuelosController;


// --- LOGIN ---
Route::get('/', [LoginController::class,'index'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

//ruta de app pa exportar excel 
Route::get('/exportar-accesos', [AccesoApiController::class, 'exportarExcel']);


// Usuarios App
Route::get('/admin/usuariosapp/index', [UsuarioAppController::class, 'index'])->name('admin.usuariosapp.index');
Route::post('/admin/usuariosapp/store', [UsuarioAppController::class, 'store'])->name('admin.usuariosapp.store');
Route::post('/admin/usuariosapp/info', [UsuarioAppController::class, 'info']);
Route::put('/admin/usuariosapp/update/{id}', [UsuarioAppController::class, 'update'])->name('admin.usuariosapp.update');
Route::put('/admin/usuariosapp/toggle/{id}', [UsuarioAppController::class, 'toggleActivo']);

//CHATBOT
Route::get('/chatbot/opciones', [ChatFlowController::class, 'getOpciones']);
Route::get('/chatbot/mensaje-final/{id}', [ChatFlowController::class, 'getMensajeFinal']);


// --- CONTROL WEB ---
Route::get('/panel', [ControlController::class,'indexRedireccionamiento'])->name('admin.panel');
Route::get('/admin/home', [ControlController::class, 'home'])->name('admin.home');
Route::get('/admin/grafico-logins', [ControlController::class, 'graficoLogins']);
Route::get('/admin/acceso/grafico-por-hora', [ControlController::class, 'graficoAccesoPorHora']);



// ---RUTAS DE ACCESOS ---
Route::get('/admin/accesos/index', [AccesoFrontendController::class, 'index'])->name('admin.accesos.index');
Route::get('/admin/accesos/create', [AccesoFrontendController::class, 'create'])->name('admin.accesos.create');
Route::post('/admin/acceso/store', [AccesoFrontendController::class, 'store'])->name('admin.accesos.store');
Route::get('/admin/acceso/show', [AccesoFrontendController::class, 'index'])->name('admin.accesos.show');
Route::get('/admin/acceso/edit/{acceso}', [AccesoFrontendController::class, 'edit'])->name('admin.accesos.edit');
Route::put('/admin/acceso/update/{acceso}', [AccesoFrontendController::class, 'update'])->name('admin.accesos.update');
Route::delete('/admin/acceso/{acceso}', [AccesoFrontendController::class, 'destroy'])->name('admin.accesos.destroy');



//estas despues la voy a quitar 
Route::get('/index', [ControlAeronaveController::class, 'index'])->name('admin.controlaeronave.index');
Route::get('/create', [ControlAeronaveController::class, 'create'])->name('admin.controlaeronave.create');
Route::post('/store', [ControlAeronaveController::class, 'store'])->name('admin.controlaeronave.store');
// Alias tipo “show” apuntando al index (igual que en tu módulo de accesos)
Route::get('/show', [ControlAeronaveController::class, 'index'])->name('admin.controlaeronave.show');
Route::get('/edit/{control}', [ControlAeronaveController::class, 'edit'])->name('admin.controlaeronave.edit');
Route::put('/update/{control}', [ControlAeronaveController::class, 'update'])->name('admin.controlaeronave.update');
Route::delete('/{control}', [ControlAeronaveController::class, 'destroy'])->name('admin.control.destroy');
// Ruta nueva que guarda solo los últimos 10 campos
Route::post('/store-acceso', [ControlAeronaveController::class, 'storeAcceso'])->name('admin.controlaeronave.storeAcceso');
// Tu resource del control (ajusta los métodos que uses)
Route::resource('control-aeronave', ControlAeronaveController::class);


//RUTAS DE VUELO
Route::get('/admin/vuelos/index', [VueloFrontendController::class, 'index'])->name('admin.vuelo.index');
Route::get('/admin/vuelos/create', [VueloFrontendController::class, 'create'])->name('admin.vuelo.create');
Route::post('/admin/vuelo/store', [VueloFrontendController::class, 'store'])->name('admin.vuelo.store');
Route::get('/admin/vuelos/show', [VueloFrontendController::class, 'index'])->name('admin.vuelo.show');
Route::get('/admin/vuelo/edit/{vuelo}', [VueloFrontendController::class, 'edit'])->name('admin.vuelo.edit');
Route::put('/admin/vuelo/update/{vuelo}', [VueloFrontendController::class, 'update'])->name('admin.vuelo.update');
Route::delete('/admin/vuelo/{vuelo}', [VueloFrontendController::class, 'destroy'])->name('admin.vuelo.destroy');


//NUEVA VISTA VUELOS CON LAS RELACIONES DE LAS 5 TABLAS 
// LISTA
Route::get('/admin/vuelos', [VuelosController::class, 'index'])->name('admin.vuelo.index');
// FORM CREAR
Route::get('/admin/vuelos/create', [VuelosController::class, 'create'])->name('admin.vuelo.create');
// GUARDAR
Route::post('/admin/vuelos', [VuelosController::class, 'store'])->name('admin.vuelo.store');
// VER DETALLE
Route::get('/admin/vuelos/{vuelo}', [VuelosController::class, 'show'])->name('admin.vuelo.show')->whereNumber('vuelo');
// FORM EDITAR
Route::get('/admin/vuelos/{vuelo}/edit', [VuelosController::class, 'edit'])->name('admin.vuelo.edit')->whereNumber('vuelo');
// ACTUALIZAR
Route::put('/admin/vuelos/{vuelo}', [VuelosController::class, 'update'])->name('admin.vuelo.update')->whereNumber('vuelo');
// ELIMINAR
Route::delete('/admin/vuelos/{vuelo}', [VuelosController::class, 'destroy'])->name('admin.vuelo.destroy')->whereNumber('vuelo');


// RUTAS DE TIPO

Route::get('/admin/tipo/index', [tipoController::class, 'index'])->name('admin.tipo.index');
Route::get('/admin/tipos/create', [tipoController::class, 'create'])->name('admin.tipo.create');
Route::post('/admin/tipo/store', [tipoController::class, 'store'])->name('admin.tipo.store');
Route::get('/admin/tipo/show', [tipoController::class, 'index'])->name('admin.tipo.show');
Route::get('/admin/tipo/edit/{tipo}', [tipoController::class, 'edit'])->name('admin.tipo.edit');
Route::put('/admin/tipo/update/{tipo}', [tipoController::class, 'update'])->name('admin.tipo.update');
Route::delete('/admin/tipo/{tipo}', [tipoController::class, 'destroy'])->name('admin.tipo.destroy');


// --- ROLES ---

Route::get('/admin/roles/index', [RolesController::class,'index'])->name('admin.roles.index');
Route::get('/admin/roles/tabla', [RolesController::class,'tablaRoles']);
Route::get('/admin/roles/lista/permisos/{id}', [RolesController::class,'vistaPermisos']);
Route::get('/admin/roles/permisos/tabla/{id}', [RolesController::class,'tablaRolesPermisos']);
Route::post('/admin/roles/permiso/borrar', [RolesController::class, 'borrarPermiso']);
Route::post('/admin/roles/permiso/agregar', [RolesController::class, 'agregarPermiso']);
Route::get('/admin/roles/permisos/lista', [RolesController::class,'listaTodosPermisos']);
Route::get('/admin/roles/permisos-todos/tabla', [RolesController::class,'tablaTodosPermisos']);
Route::post('/admin/roles/borrar-global', [RolesController::class, 'borrarRolGlobal']);

// --- ACCESO A GEOLOCALIZACIÓN
Route::get('/ubicaciones/mapa', [UbicacionFrontendController::class, 'mapa'])->name('ubicaciones.mapa');

// --- PERMISOS A USUARIOS ---

Route::get('/admin/permisos/index', [PermisoController::class,'index'])->name('admin.permisos.index');
Route::get('/admin/permisos/tabla', [PermisoController::class,'tablaUsuarios']);
Route::post('/admin/permisos/nuevo-usuario', [PermisoController::class, 'nuevoUsuario']);
Route::post('/admin/permisos/info-usuario', [PermisoController::class, 'infoUsuario']);
Route::post('/admin/permisos/editar-usuario', [PermisoController::class, 'editarUsuario']);
Route::post('/admin/permisos/nuevo-rol', [PermisoController::class, 'nuevoRol']);
Route::post('/admin/permisos/extra-nuevo', [PermisoController::class, 'nuevoPermisoExtra']);
Route::post('/admin/permisos/extra-borrar', [PermisoController::class, 'borrarPermisoGlobal']);

// --- PERFIL DE USUARIO ---
Route::get('/admin/editar-perfil/index', [PerfilController::class,'indexEditarPerfil'])->name('admin.perfil');
Route::post('/admin/editar-perfil/actualizar', [PerfilController::class, 'editarUsuario']);

// --- SIN PERMISOS VISTA 403 ---
Route::get('sin-permisos', [ControlController::class,'indexSinPermiso'])->name('no.permisos.index');

Route::get('/admin/dashboard', [DashboardController::class,'vistaDashboard'])->name('admin.dashboard.index');


//RUTAS PARA LOS REPORTES PFD
Route::get('\reporte', [ReportController::class,'ReporteUno'])->name('admin.reporte.uno');

Route::get('/reportes', [ReportController::class, 'vistaPanelReportes'])->name('reportes.panel');
//rutas ya agregadas pa despues cambiar # en las cards panel reporte
Route::get('/reportes/accesos', [ReportController::class, 'reporteAccesos'])->name('reportes.accesos');
Route::get('/reportes/accesos/pdf', [ReportController::class, 'reporteAccesosPdf'])->name('reportes.accesos.pdf');
Route::get('/reportes/accesos/excel', [ReportController::class, 'reporteAccesosExcel'])->name('reportes.accesos.excel');
Route::get('/reporte-accesos/buscar', [ReportController::class, 'buscarAccesos'])->name('reportes.accesos.buscar');


Route::get('/reportes/tipos', [ReportController::class, 'reporteTipos'])->name('reportes.tipos');
Route::get('/reportes/tipos/buscar', [ReportController::class, 'buscarTipos'])->name('reportes.tipos.buscar');
Route::get('/reportes/tipos/pdf', [ReportController::class, 'exportarTiposPDF'])->name('reportes.tipos.pdf');
Route::get('/reportes/tipos/excel', [ReportController::class, 'exportarTiposExcel'])->name('reportes.tipos.excel');


Route::get('/reportes/vuelos', [ReportController::class, 'reporteVuelos'])->name('reportes.vuelos');
Route::get('/reportes/vuelos/buscar', [ReportController::class, 'buscarVuelos'])->name('reportes.vuelos.buscar');
Route::get('/reportes/vuelos/pdf', [ReportController::class, 'exportarVuelosPDF'])->name('reportes.vuelos.pdf');
Route::get('/reportes/vuelos/excel', [ReportController::class, 'exportarVuelosExcel'])->name('reportes.vuelos.excel');


Route::get('/reportes/ubicaciones', [ReportController::class, 'reporteUbicaciones'])->name('reportes.ubicaciones');
Route::get('/reportes/usuariosapp', [ReportController::class, 'reporteUsuariosApp'])->name('reportes.usuariosapp');



 // Listado con filtros
Route::get('/control-aeronave', [ReportController::class, 'controlAeronaveIndex'])->name('reportes.control_aeronave.index');
    // PDF por registro
Route::get('/control-aeronave/{id}/pdf', [ReportController::class, 'controlAeronavePdf'])->name('reportes.control_aeronave.pdf');


// routes/web.php
Route::get('/reportes/control-aeronave/{id}/pdf',[ReportController::class, 'pdf'])->name('reportes.control_aeronave.pdf');

Route::get('/reportes/control-aeronave/{id}/pdf', [ReportController::class, 'controlAeronavePdf'])->name('reportes.control_aeronave.pdf');

// (Opcional) vista HTML para previsualizar antes de exportar
Route::get('/reportes/control-aeronave/{id}/preview', [ReportController::class, 'controlAeronavePreview'])->name('reportes.control_aeronave.preview');




//nuevas rutas para controlAeronaveController y accesosPerosnaController

Route::get('/admin/controlaeronave', [ControlAeronaveController::class, 'index1'])
    ->name('admin.controlaeronave.index');


Route::get('/admin/controlaeronave/{control}/edit', [ControlAeronaveController::class, 'edit1'])
    ->name('admin.controlaeronave.edit');
Route::put('/admin/controlaeronave/{control}', [ControlAeronaveController::class, 'update1'])
    ->name('admin.controlaeronave.update');
Route::delete('/admin/controlaeronave/{control}', [ControlAeronaveController::class, 'destroy1'])
    ->name('admin.controlaeronave.destroy');

// ACCESOS (modal)
Route::get('/admin/controlaeronave/{control}/accesos', [ControlAeronaveController::class, 'accesosIndex'])
    ->name('accesos-personal.index');
Route::post('/admin/controlaeronave/accesos', [ControlAeronaveController::class, 'accesosStore'])
    ->name('accesos-personal.store');
Route::delete('/admin/controlaeronave/accesos/{acceso}', [ControlAeronaveController::class, 'accesosDestroy'])
    ->name('accesos-personal.destroy');




// LISTA (usa tu index.blade.php)
Route::get('/admin/controlaeronave',            [ControlAeronaveController::class, 'index'])->name('admin.controlaeronave.index');

// CREATE (usa tu create.blade.php)
Route::get('/admin/controlaeronave/create',     [ControlAeronaveController::class, 'create'])->name('admin.controlaeronave.create');
Route::post('/admin/controlaeronave',           [ControlAeronaveController::class, 'store'])->name('admin.controlaeronave.store');

// EDIT / UPDATE / DESTROY (cuando los habilites)
Route::get('/admin/controlaeronave/{vuelo}/edit',  [ControlAeronaveController::class, 'edit'])->name('admin.controlaeronave.edit');
Route::put('/admin/controlaeronave/{vuelo}',       [ControlAeronaveController::class, 'update'])->name('admin.controlaeronave.update');
Route::delete('/admin/controlaeronave/{vuelo}',    [ControlAeronaveController::class, 'destroy'])->name('admin.controlaeronave.destroy');

// RUTAS para el MODAL “Accesos”
// JSON para tablas (modal/detalles)
Route::get('/admin/controlaeronave/{control}/accesos', [accesos_personalController::class, 'index'])->name('accesos-personal.index');

// Guardar desde el modal
Route::post('/admin/controlaeronave/accesos', [accesos_personalController::class, 'store'])->name('accesos-personal.store');

// Eliminar uno
Route::delete('/admin/controlaeronave/accesos/{acceso}', [accesos_personalController::class, 'destroy'])->name('accesos-personal.destroy');



Route::get('/admin/controlaeronave/create', [ControlAeronaveController::class, 'create1'])->name('admin.controlaeronave.create');
Route::post('/admin/controlaeronave', [ControlAeronaveController::class, 'store1'])->name('admin.controlaeronave.store');