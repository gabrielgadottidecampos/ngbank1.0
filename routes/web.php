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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/equipes', function (){
   return view('app.equipes');
})->name('equipes')->middleware('auth');

// rota para funcionarios **********************************************************************************************
Route::get('/funcionarios', function (){
    return view('app.funcionarios');
})->name('funcionarios')->middleware('auth');
// fim rotas para funcionarios -----------------------------------------------------------------------------------------

// rota para Vendas **********************************************************************************************
Route::get('/vendas', function (){
    return view('app.vendas');
})->name('vendas')->middleware('auth');
// fim rotas para Vendas -----------------------------------------------------------------------------------------

Route::get('/principal', function (){
    return view('app.principal');
})->name('principal')->middleware('auth');
// fim rotas para Vendas -----------------------------------------------------------------------------------------
Route::get('/equipecamarote', function (){
    return view('app.equipeCamarote');
})->name('equipeCamarote')->middleware('auth');
// fim rotas para Vendas -----------------------------------------------------------------------------------------
// fim rotas para Vendas -----------------------------------------------------------------------------------------
Route::get('/melhoresdodia', function (){
    return view('app.melhorDia');
})->name('melhoresdodia')->middleware('auth');
// fim rotas para Vendas -----------------------------------------------------------------------------------------
