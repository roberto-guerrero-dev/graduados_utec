<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraduadosController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/graduados', [GraduadosController::class, 'index'])->name('graduados.index');
Route::post('/graduados', [GraduadosController::class, 'store'])->name('graduados.store');
Route::get('/graduados/{id}/edit', [GraduadosController::class, 'edit'])->name('graduados.edit');
Route::put('/graduados/{id}', [GraduadosController::class, 'update'])->name('graduados.update');
Route::delete('/graduados/{id}', [GraduadosController::class, 'destroy'])->name('graduados.destroy');