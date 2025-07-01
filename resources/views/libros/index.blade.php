{{-- resources/views/libros/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Libros')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-books"></i> Gestión de Libros</h1>
    <a href="{{ route('libros.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nuevo Libro
    </a>
</div>

<!-- Barra de búsqueda -->
<div class="row mb-4">
    <div class="col-md-8">
        <form action="{{ route('libros.search') }}" method="POST" class="d-flex">
            @csrf
            <input type="text" name="busqueda" class="form-control" 
                   placeholder="Buscar por título, autor o ISBN..."
                   value="{{ $termino ?? '' }}">
            <button type="submit" class="btn btn-outline-primary ms-2">
                <i class="bi bi-search"></i> Buscar
            </button>
        </form>
    </div>
    <div class="col-md-4 text-end">
        @if(isset($termino))
            <a href="{{ route('libros.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Limpiar búsqueda
            </a>
        @endif
    </div>
</div>

<!-- Tabla de libros -->
<div class="card">
    <div class="card-body">
        @if(count($libros) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>ISBN</th>
                            <th>Disponibles</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($libros as $libro)
                        <tr>
                            <td>{{ $libro['ID_LIBRO'] }}</td>
                            <td>{{ $libro['TITULO'] }}</td>
                            <td>{{ $libro['AUTOR'] ?? 'N/A' }}</td>
                            <td>{{ $libro['NOMBRE_CATEGORIA'] ?? 'N/A' }}</td>
                            <td>{{ $libro['ISBN'] ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $libro['CANTIDAD_DISPONIBLE'] > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $libro['CANTIDAD_DISPONIBLE'] }}/{{ $libro['CANTIDAD_TOTAL'] }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $libro['ESTADO'] == 'Disponible' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $libro['ESTADO'] }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('libros.show', $libro['ID_LIBRO']) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('libros.edit', $libro['ID_LIBRO']) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('libros.destroy', $libro['ID_LIBRO']) }}" 
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('¿Está seguro de eliminar este libro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-book display-1 text-muted"></i>
                <h4 class="mt-3">No se encontraron libros</h4>
                <p class="text-muted">
                    @if(isset($termino))
                        No hay libros que coincidan con "{{ $termino }}"
                    @else
                        Comience agregando algunos libros a la biblioteca
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection