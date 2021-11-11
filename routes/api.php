<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// rotas do app ********************************************************************************************************
Route::apiResource('equipe','App\Http\Controllers\EquipeController'); // rota para equipes
Route::apiResource('funcionario','App\Http\Controllers\FuncionarioController'); // rota para funcionarios
Route::apiResource('venda','App\Http\Controllers\VendaController');//rota para vendas
// fim rotas do app ____________________________________________________________________________________________________
