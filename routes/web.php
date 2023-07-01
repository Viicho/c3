<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\CuentaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name("home");
Route::get('/iniciar_sesion', [HomeController::class, 'iniciar_sesion'])->name("login");
Route::post('/iniciar_sesion', [HomeController::class, 'iniciar_sesion_post'])->name("iniciar_sesion_post");
Route::get('/crear_cuenta', [HomeController::class, 'crear_cuenta'])->name("crear_cuenta");
Route::post('/crear_cuenta', [HomeController::class, 'crear_cuenta_post'])->name("crear_cuenta_post");
Route::get('/cerrar_sesion', [HomeController::class, 'cerrar_sesion'])->name("cerrar_sesion");

Route::get('/mi_cuenta', [HomeController::class, 'mi_cuenta'])->name("mi_cuenta")->middleware('auth');

Route::post('/imagen/upload', [ImagenController::class, 'upload'])->name("imagen_upload")->middleware('auth');
Route::delete('/imagen/{imagen}', [ImagenController::class, 'delete'])->name("imagen_delete")->middleware('auth');
Route::post('/imagen/{imagen}', [ImagenController::class, 'update'])->name("imagen_update")->middleware('auth');
Route::put('/imagen/banear/{imagen}', [ImagenController::class, 'banear'])->name("banear")->middleware('auth');
Route::put('/imagen/desbanear/{imagen}', [ImagenController::class, 'desbanear'])->name("desbanear")->middleware('auth');

Route::post('/cuenta', [CuentaController::class, 'create'])->name("cuenta_create")->middleware('auth');
Route::put('/cuenta/{cuenta}', [CuentaController::class, 'update'])->name("cuenta_update")->middleware('auth');
Route::delete('/cuenta/{cuenta}', [CuentaController::class, 'delete'])->name("cuenta_delete")->middleware('auth');
