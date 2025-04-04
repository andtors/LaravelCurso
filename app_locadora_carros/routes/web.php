<?php

use Illuminate\Support\Facades\Route;


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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/marcas', function(){ return view('app.marcas');})->name('marcas')->middleware('auth');
Route::get('/clientes', function(){ return view('app.clientes');})->name('clientes')->middleware('auth');
Route::get('/modelos', function(){ return view('app.modelos');})->name('modelos')->middleware('auth');
Route::get('/carros', function(){ return view('app.carros');})->name('carros')->middleware('auth');
Route::get('/locacoes', function(){ return view('app.locacoes');})->name('locacoes')->middleware('auth');