{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - Biblioteca Virtual')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="bi bi-speedometer2"></i> Dashboard - Biblioteca Virtual
        </h1>
        <p class="lead text-muted">Sistema Integral de Gestión Bibliotecaria</p>
    </div>
</div>

<div class="row">
    <!-- Módulo de Gestión de Libros -->
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-books"></i> Módulo 2: Gestión de Libros
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Administra el catálogo completo de libros de la biblioteca. 
                    Incluye funcionalidades CRUD completas desarrolladas con PL/SQL.

                </p>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-plus-circle"></i> Agregar Libros</span>
                        <span class="badge bg-success rounded-pill">CRUD</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-pencil"></i> Actualización de registros</span>
                        <span class="badge bg-warning rounded-pill">PL/SQL</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-search"></i> Búsqueda Libros</span>
                        <span class="badge bg-info rounded-pill">Indexado</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-tags"></i> Gestión de categorías</span>
                        <span class="badge bg-secondary rounded-pill">Dewey</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('libros.index') }}" class="btn btn-primary w-100">
                    <i class="bi bi-arrow-right"></i> Acceder al Modulo
                </a>
            </div>
        </div>
    </div>

    <!-- Módulo de Gestión de Préstamos -->
    <div class="col-md-6 mb-4">
        <div class="card h-100 border-success">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-journal-check"></i>  Módulo 3: Gestión de Préstamos

                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Controla todo el proceso de préstamos y devoluciones. 
                    Sistema completo con validaciones y cálculo automático de multas.

                </p>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-journal-plus"></i> Registrar préstamos</span>
                        <span class="badge bg-success rounded-pill">validaciones</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-journal-check"></i> Procesar devoluciones</span>
                        <span class="badge bg-warning rounded-pill">Sanciones</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-clock-history"></i> Historial completo</span>
                        <span class="badge bg-info rounded-pill">Reportes</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-arrow-repeat"></i> Renobar Prestamos</span>
                        <span class="badge bg-secondary rounded-pill">Control</span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('prestamos.index') }}" class="btn btn-success w-100">
                    <i class="bi bi-arrow-right"></i> Acceder al Módulo
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Accesos Rápidos -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-lightning"></i> Accesos Rápidos</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('autores.index') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-person-lines-fill"></i><br>
                            <small>Gestión de Autores</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('categorias.index') }}" class="btn btn-outline-info w-100 mb-2">
                            <i class="bi bi-tags"></i><br>
                            <small>Clasificación por Materias</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('prestamos.vencidos') }}" class="btn btn-outline-danger w-100 mb-2">
                            <i class="bi bi-exclamation-triangle"></i><br>
                            <small>Préstamos Vencidos</small>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('prestamos.historial') }}" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="bi bi-clock-history"></i><br>
                            <small>Reportes</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection







