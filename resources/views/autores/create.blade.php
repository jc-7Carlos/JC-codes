{{-- resources/views/autores/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear Autor')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3><i class="bi bi-plus-circle"></i> Agregar Nuevo Autor</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('autores.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_autor" class="form-label">Nombre *</label>
                            <input type="text" class="form-control @error('nombre_autor') is-invalid @enderror" 
                                   id="nombre_autor" name="nombre_autor" value="{{ old('nombre_autor') }}" 
                                   required placeholder="Ej: Gabriel">
                            @error('nombre_autor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido_autor" class="form-label">Apellido *</label>
                            <input type="text" class="form-control @error('apellido_autor') is-invalid @enderror" 
                                   id="apellido_autor" name="apellido_autor" value="{{ old('apellido_autor') }}" 
                                   required placeholder="Ej: García Márquez">
                            @error('apellido_autor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nacionalidad" class="form-label">Nacionalidad</label>
                        <input type="text" class="form-control @error('nacionalidad') is-invalid @enderror" 
                               id="nacionalidad" name="nacionalidad" value="{{ old('nacionalidad') }}" 
                               placeholder="Ej: Colombiana, Peruana, Española">
                        @error('nacionalidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                               id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                               max="{{ date('Y-m-d') }}">
                        @error('fecha_nacimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Ejemplos de autores:</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong>Gabriel García Márquez</strong> - Colombiana</li>
                            <li><strong>Mario Vargas Llosa</strong> - Peruana</li>
                            <li><strong>Isabel Allende</strong> - Chilena</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('autores.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Crear Autor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection