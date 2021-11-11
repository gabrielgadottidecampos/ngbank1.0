<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// rotas do app ********************************************************************************************************
Route::prefix('v1')->middleware('jwt.auth')->group(function() {
    Route::apiResource('equipe','App\Http\Controllers\EquipeController')->middleware('jwt.auth'); // rota para equipes
    Route::apiResource('funcionario','App\Http\Controllers\FuncionarioController'); // rota para funcionarios
    Route::apiResource('venda','App\Http\Controllers\VendaController');//rota para vendas
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
});
// fim rotas do app ____________________________________________________________________________________________________


Route::post('login', 'App\Http\Controllers\AuthController@login');



