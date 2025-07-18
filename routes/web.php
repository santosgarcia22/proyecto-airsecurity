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

use App\Http\Controllers\Backend\Dashboard\DashboardController;
// --- LOGIN ---
Route::get('/', [LoginController::class,'index'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Usuarios App
Route::get('/admin/usuariosapp/index', [UsuarioAppController::class, 'index'])->name('admin.usuariosapp.index');
Route::post('/admin/usuariosapp/nuevo', [UsuarioAppController::class, 'store'])->name('admin.usuariosapp.store');
Route::post('/admin/usuariosapp/info', [UsuarioAppController::class, 'info']);
Route::post('/admin/usuariosapp/editar', [UsuarioAppController::class, 'update']);
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

//RUTAS DE VUELOS
Route::get('/admin/vuelos/index', [VueloFrontendController::class, 'index'])->name('admin.vuelo.index');
Route::get('/admin/vuelos/create', [VueloFrontendController::class, 'create'])->name('admin.vuelo.create');
Route::post('/admin/vuelo/store', [VueloFrontendController::class, 'store'])->name('admin.vuelo.store');
Route::get('/admin/vuelos/show', [VueloFrontendController::class, 'index'])->name('admin.vuelo.show');

Route::get('/admin/vuelo/edit/{vuelo}', [VueloFrontendController::class, 'edit'])->name('admin.vuelo.edit');
Route::put('/admin/vuelo/update/{vuelo}', [VueloFrontendController::class, 'update'])->name('admin.vuelo.update');

Route::delete('/admin/vuelo/{vuelo}', [VueloFrontendController::class, 'destroy'])->name('admin.vuelo.destroy');

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
