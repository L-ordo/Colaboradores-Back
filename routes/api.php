<?php
use App\Http\Controllers\Api\PaisController;
use App\Http\Controllers\Api\DepartamentoController;
use App\Http\Controllers\Api\MunicipioController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\ColaboradorController;

Route::apiResource('paises', PaisController::class);
Route::apiResource('departamentos', DepartamentoController::class);
Route::apiResource('municipios', MunicipioController::class);
Route::apiResource('empresas', EmpresaController::class);
Route::apiResource('colaboradores', ColaboradorController::class);
