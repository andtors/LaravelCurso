<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\locacaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::apiResource('cliente', ClienteController::class);
Route::apiResource('carro', CarroController::class);
Route::apiResource('locacao', locacaoController::class);
Route::apiResource('marca', MarcaController::class);
Route::apiResource('modelo', ModeloController::class);