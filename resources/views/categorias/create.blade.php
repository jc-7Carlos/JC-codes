{{-- resources/views/categorias/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3><i class="bi bi-plus-circle"></i> Crear Nueva Categoría</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nombre_categoria" class="form-label">Nombre de la Categoría *</label>
                        <input type="text" class="form-control @error('nombre_categoria') is-invalid @enderror" 
                               id="nombre_categoria" name="nombre_categoria" value="{{ old('nombre_categoria') }}" 
                               required placeholder="Ej: Ficción, Ciencia, Historia">
                        @error('nombre_categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" name="descripcion" rows="3"
                                  placeholder="Breve descripción de la categoría...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Ejemplos de categorías:</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong>Ficción:</strong> Novelas y cuentos imaginarios</li>
                            <li><strong>Ciencia:</strong> Libros científicos y técnicos</li>
                            <li><strong>Historia:</strong> Libros históricos y biografías</li>
                            <li><strong>Romance:</strong> Novelas románticas</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Crear Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
