<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;

// API Gestión de Libros
Route::prefix('libros')->name('api.libros.')->group(function () {
    Route::get('/', [LibroController::class, 'apiIndex'])->name('index');
    Route::post('/', [LibroController::class, 'apiStore'])->name('store');
    Route::get('/{id}', [LibroController::class, 'show'])->name('show');
    Route::put('/{id}', [LibroController::class, 'update'])->name('update');
    Route::delete('/{id}', [LibroController::class, 'destroy'])->name('destroy');
    Route::post('/buscar', [LibroController::class, 'search'])->name('search');
});

// API Gestión de Préstamos
Route::prefix('prestamos')->name('api.prestamos.')->group(function () {
    Route::get('/activos', [PrestamoController::class, 'apiPrestamosActivos'])->name('activos');
    Route::post('/', [PrestamoController::class, 'apiRegistrarPrestamo'])->name('registrar');
    Route::put('/{id}/devolver', [PrestamoController::class, 'apiDevolverLibro'])->name('devolver');
    Route::get('/historial', [PrestamoController::class, 'apiHistorial'])->name('historial');
    Route::get('/vencidos', [PrestamoController::class, 'apiPrestamosVencidos'])->name('vencidos');
    Route::put('/{id}/renovar', [PrestamoController::class, 'procesarRenovacion'])->name('renovar');
});


