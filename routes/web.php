<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraduadosController;
use App\Http\Controllers\VGraduadosCarrerasController;
use App\Http\Controllers\FacultadesController;
use App\Http\Controllers\CarrerasController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/graduados', [GraduadosController::class, 'index'])->name('graduados.index');
Route::post('/graduados', [GraduadosController::class, 'store'])->name('graduados.store');
Route::get('/graduados/{id}/edit', [GraduadosController::class, 'edit'])->name('graduados.edit');
Route::put('/graduados/{id}', [GraduadosController::class, 'update'])->name('graduados.update');
Route::delete('/graduados/{id}', [GraduadosController::class, 'destroy'])->name('graduados.destroy');
Route::get('/graduados/data', [GraduadosController::class, 'data']);
Route::get('/graduados/form', [GraduadosController::class, 'createForm'])->name('graduados.form');
Route::post('/graduados/store-full', [GraduadosController::class, 'storeFull'])->name('graduados.storeFull');
Route::get('/graduados-carreras/data', [VGraduadosCarrerasController::class, 'data']);
Route::post('/facultades', [FacultadesController::class, 'store'])->name('facultades.store');
Route::get('/facultades', [FacultadesController::class, 'index'])->name('facultades.facultades');
Route::get('/facultades/data', [FacultadesController::class, 'data']);
Route::get('/carreras', [CarrerasController::class, 'index'])->name('carreras.carreras');
Route::post('/carreras', [CarrerasController::class, 'store'])->name('carreras.store');
Route::get('/carreras/data', [CarrerasController::class, 'data']);

