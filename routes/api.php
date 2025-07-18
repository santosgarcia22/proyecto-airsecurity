<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AccesoApiController;
use App\Http\Controllers\Api\TipoAppController;
use App\Http\Controllers\Api\VueloAppController;
use App\Http\Controllers\Api\UsuarioAppController;
use App\Http\Controllers\Api\ChatGPTController;
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

 Route::post('/chatgpt', [ChatGPTController::class, 'responder']);