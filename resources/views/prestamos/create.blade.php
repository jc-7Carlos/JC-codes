{{-- resources/views/prestamos/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Préstamo')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3><i class="bi bi-plus-circle"></i> Registrar Nuevo Préstamo</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('prestamos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">ID del Usuario *</label>
                        <input type="number" class="form-control @error('id_usuario') is-invalid @enderror" 
                               id="id_usuario" name="id_usuario" value="{{ old('id_usuario') }}" required>
                        <div class="form-text">Ingrese el ID del usuario que solicitará el préstamo</div>
                        @error('id_usuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_libro" class="form-label">Libro *</label>
                        <select class="form-select @error('id_libro') is-invalid @enderror" 
                                id="id_libro" name="id_libro" required>
                            <option value="">Seleccione un libro disponible</option>
                            @foreach($libros as $libro)
                                <option value="{{ $libro['ID_LIBRO'] }}" 
                                        {{ old('id_libro') == $libro['ID_LIBRO'] ? 'selected' : '' }}>
                                    {{ $libro['TITULO'] }} - Disponibles: {{ $libro['CANTIDAD_DISPONIBLE'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_libro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dias_prestamo" class="form-label">Días de Préstamo</label>
                        <select class="form-select @error('dias_prestamo') is-invalid @enderror" 
                                id="dias_prestamo" name="dias_prestamo">
                            <option value="7" {{ old('dias_prestamo') == '7' ? 'selected' : '' }}>7 días</option>
                            <option value="15" {{ old('dias_prestamo', '15') == '15' ? 'selected' : '' }}>15 días (por defecto)</option>
                            <option value="30" {{ old('dias_prestamo') == '30' ? 'selected' : '' }}>30 días</option>
                        </select>
                        @error('dias_prestamo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Información importante:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Cada usuario puede tener máximo 3 préstamos activos</li>
                            <li>El libro debe tener ejemplares disponibles</li>
                            <li>Se aplicará multa de $2 por día de retraso</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Registrar Préstamo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection