<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\SobreNosController;
use App\Http\Controllers\ContatoController;

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

/*
Route::get('/', function () {
    return "Olá seja bem vindo";
});

Route::get('/sobrenos', function () {
    return "Sobre nós";
});

Route::get('/contato', function () {
    return "Contato";
});

Route::get(
    '/contato/{nome}/{categoria_id}', 
     function(
      string $nome = "Desconhecido",
      int $categoria_id = 1, // 1 - informação
      ) {
    echo "Estamos aqui $nome - $categoria_id";
})-> where('categoria_id', '[0-9]+')-> where('nome', '[A-Za-z]+');
// nome, categoria, assunto, mensagem

*/

Route::get('/', [PrincipalController::class, 'principal'])->name('site.index');
Route::get('/sobrenos', [SobreNosController::class, 'sobreNos'])->name('site.sobrenos');
Route::get('/contato', [ContatoController::class, 'contato'])->name('site.contato');
Route::get('/login', function(){ return 'Login'; })->name('site.login');

Route::prefix('/app')->group(function(){

    Route::get('/clientes', function(){ return 'Clientes'; })->name('app.clientes');
    Route::get('/fornecedores', function(){ return 'Fornecedores'; })->name('app.fornecedores');
    Route::get('/produtos', function(){ return 'Produtos'; })->name('app.produtos');

});

Route::get('/rota1', function(){
    echo "Rota 1";
})->name('site.rota1');


Route::get('/rota2', function(){
    return redirect()->route('site.rota1');
})->name('site.rota2');

// Route::redirect('/rota2', 'rota1');



Route::fallback(function() {
    echo "A rota acessada não existe.";
});



