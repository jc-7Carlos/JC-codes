{{-- resources/views/categorias/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3><i class="bi bi-pencil-square"></i> Editar Categoría</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('categorias.update', $result['ID_CATEGORIA']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nombre_categoria" class="form-label">Nombre de la Categoría *</label>
                        <input type="text" class="form-control @error('nombre_categoria') is-invalid @enderror" 
                               id="nombre_categoria" name="nombre_categoria" 
                               value="{{ old('nombre_categoria', $result['NOMBRE_CATEGORIA']) }}" 
                               required placeholder="Ej: Ficción, Ciencia, Historia">
                        @error('nombre_categoria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" name="descripcion" rows="3"
                                  placeholder="Breve descripción de la categoría...">{{ old('descripcion', $result['DESCRIPCION']) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Importante:</strong> Si esta categoría tiene libros asociados, el cambio de nombre se reflejará en todos ellos.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Actualizar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection