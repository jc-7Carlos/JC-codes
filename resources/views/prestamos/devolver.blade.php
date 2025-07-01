{{-- resources/views/prestamos/devolver.blade.php --}}
@extends('layouts.app')

@section('title', 'Devolver Libro')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3><i class="bi bi-check-circle"></i> Devolver Libro</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('prestamos.procesar-devolucion', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Información:</strong> Está procesando la devolución del préstamo ID: <strong>{{ $id }}</strong>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones (opcional)</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" name="observaciones" rows="4"
                                  placeholder="Ingrese cualquier observación sobre el estado del libro o la devolución...">{{ old('observaciones') }}</textarea>
                        <div class="form-text">
                            Ejemplo: "Libro en buen estado", "Páginas dañadas", "Devolución tardía por enfermedad", etc.
                        </div>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Importante:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Se calculará automáticamente cualquier multa por retraso</li>
                            <li>El libro será marcado como disponible nuevamente</li>
                            <li>Esta acción no se puede deshacer</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Confirmar Devolución
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection