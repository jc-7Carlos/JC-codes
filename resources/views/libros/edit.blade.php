{{-- resources/views/libros/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Libro')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3><i class="bi bi-pencil-square"></i> Editar Libro</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('libros.update', $libro['ID_LIBRO']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="titulo" class="form-label">Título *</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                   id="titulo" name="titulo" value="{{ old('titulo', $libro['TITULO']) }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control @error('isbn') is-invalid @enderror" 
                                   id="isbn" name="isbn" value="{{ old('isbn', $libro['ISBN']) }}">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_autor" class="form-label">Autor *</label>
                            <select class="form-select @error('id_autor') is-invalid @enderror" 
                                    id="id_autor" name="id_autor" required>
                                <option value="">Seleccione un autor</option>
                                @foreach($autores as $autor)
                                    <option value="{{ $autor['ID_AUTOR'] }}" 
                                            {{ old('id_autor', $libro['ID_AUTOR']) == $autor['ID_AUTOR'] ? 'selected' : '' }}>
                                        {{ $autor['NOMBRE_COMPLETO'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_autor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="id_categoria" class="form-label">Categoría *</label>
                            <select class="form-select @error('id_categoria') is-invalid @enderror" 
                                    id="id_categoria" name="id_categoria" required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria['ID_CATEGORIA'] }}" 
                                            {{ old('id_categoria', $libro['ID_CATEGORIA']) == $categoria['ID_CATEGORIA'] ? 'selected' : '' }}>
                                        {{ $categoria['NOMBRE_CATEGORIA'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editorial" class="form-label">Editorial</label>
                            <input type="text" class="form-control @error('editorial') is-invalid @enderror" 
                                   id="editorial" name="editorial" value="{{ old('editorial', $libro['EDITORIAL']) }}">
                            @error('editorial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="año_publicacion" class="form-label">Año</label>
                            <input type="number" class="form-control @error('año_publicacion') is-invalid @enderror" 
                                   id="año_publicacion" name="año_publicacion" 
                                   value="{{ old('año_publicacion', $libro['AÑO_PUBLICACION']) }}" min="1000" max="{{ date('Y') }}">
                            @error('año_publicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="numero_paginas" class="form-label">Páginas</label>
                            <input type="number" class="form-control @error('numero_paginas') is-invalid @enderror" 
                                   id="numero_paginas" name="numero_paginas" 
                                   value="{{ old('numero_paginas', $libro['NUMERO_PAGINAS']) }}" min="1">
                            @error('numero_paginas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cantidad_total" class="form-label">Cantidad Total *</label>
                            <input type="number" class="form-control @error('cantidad_total') is-invalid @enderror" 
                                   id="cantidad_total" name="cantidad_total" 
                                   value="{{ old('cantidad_total', $libro['CANTIDAD_TOTAL']) }}" min="1" required>
                            @error('cantidad_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" 
                                   id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $libro['UBICACION']) }}"
                                   placeholder="Ej: Estante A-1">
                            @error('ubicacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $libro['DESCRIPCION']) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('libros.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Actualizar Libro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection