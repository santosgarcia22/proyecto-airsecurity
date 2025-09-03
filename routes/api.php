<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AccesoApiController;
use App\Http\Controllers\Api\TipoAppController;

use App\Http\Controllers\Api\UsuarioAppController;

use App\Http\Controllers\Api\VueloAppController;
use App\Http\Controllers\Api\TiemposDemorasController;
use App\Http\Controllers\Api\AccesosAppController;

//use App\Http\Controllers\Api\ChatGPTController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Opcional: versión de la API
Route::prefix('v1')->group(function () {

    // ----------- Vuelos -----------
    Route::get('/vuelos',            [VueloAppController::class, 'index']);   // listar/buscar
    Route::get('/vuelos/{vuelo}',    [VueloAppController::class, 'show']);    // detalle
    Route::post('/vuelos',           [VueloAppController::class, 'store']);

    // ----------- Encabezado: Tiempos + Demoras -----------
    // upsert tiempos y crear demora opcional para un vuelo
    Route::post('/vuelos/{vuelo}/tiempos-demoras', [TiemposDemorasController::class, 'store']);

    // ----------- Accesos -----------
    Route::get('/vuelos/{vuelo}/accesos', [AccesosAppController::class, 'index']); // lista
    Route::post('/vuelos/{vuelo}/accesos', [AccesosAppController::class, 'store']); // crear
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/accesos', [AccesoApiController::class, 'index']);
Route::get('/accesos/{id}', [AccesoApiController::class, 'show']);
Route::post('/accesos', [AccesoApiController::class, 'store']);

// rutas de tipo y vuelo api
 Route::get('/tipo', [TipoAppController::class, 'index']);
 Route::get('/vuelo', [VueloAppController::class, 'index']);

//RUTAS API PARA EL LOGIN
Route::post('login-app',
 [UsuarioAppController::class, 'login']);

 // endpoint para conectar a open ai una api

// Route::post('/chatgpt', [ChatGPTController::class, 'responder']);

 Route::get('exportar-accesos', [AccesoApiController::class, 'exportarExcel']);
