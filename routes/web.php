<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Rutas para Gestión de Libros (Módulo 2)
Route::prefix('libros')->name('libros.')->group(function () {
    Route::get('/', [LibroController::class, 'index'])->name('index');
    Route::get('/crear', [LibroController::class, 'create'])->name('create');
    Route::post('/', [LibroController::class, 'store'])->name('store');
    Route::get('/{id}', [LibroController::class, 'show'])->name('show');
    Route::get('/{id}/editar', [LibroController::class, 'edit'])->name('edit');
    Route::put('/{id}', [LibroController::class, 'update'])->name('update');
    Route::delete('/{id}', [LibroController::class, 'destroy'])->name('destroy');
    Route::post('/buscar', [LibroController::class, 'search'])->name('search');
});

// Rutas para Gestión de Préstamos (Módulo 3)
Route::prefix('prestamos')->name('prestamos.')->group(function () {
    Route::get('/', [PrestamoController::class, 'index'])->name('index');
    Route::get('/crear', [PrestamoController::class, 'create'])->name('create');
    Route::post('/', [PrestamoController::class, 'store'])->name('store');
    Route::get('/{id}/devolver', [PrestamoController::class, 'devolver'])->name('devolver');
    Route::put('/{id}/devolver', [PrestamoController::class, 'procesarDevolucion'])->name('procesar-devolucion');
    Route::get('/historial', [PrestamoController::class, 'historial'])->name('historial');
    Route::get('/usuario/{id}', [PrestamoController::class, 'usuario'])->name('usuario');
    Route::get('/vencidos', [PrestamoController::class, 'vencidos'])->name('vencidos');
    Route::get('/{id}/renovar', [PrestamoController::class, 'renovar'])->name('renovar');
    Route::put('/{id}/renovar', [PrestamoController::class, 'procesarRenovacion'])->name('procesar-renovacion');
});

// Rutas para Autores
Route::prefix('autores')->name('autores.')->group(function () {
    Route::get('/', [AutorController::class, 'index'])->name('index');
    Route::get('/crear', [AutorController::class, 'create'])->name('create');
    Route::post('/', [AutorController::class, 'store'])->name('store');
    Route::delete('/{id}', [AutorController::class, 'destroy'])->name('destroy');
});

// Rutas para Categorías
Route::prefix('categorias')->name('categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/crear', [CategoriaController::class, 'create'])->name('create');
    Route::post('/', [CategoriaController::class, 'store'])->name('store');
    Route::get('/{id}/editar', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('destroy');
});
