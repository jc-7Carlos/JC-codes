{{-- resources/views/categorias/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Categorías')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-tags"></i> Gestión de Categorías</h1>
    <a href="{{ route('categorias.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nueva Categoría
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if(count($result) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result as $categoria)
                        <tr>
                            <td>{{ $categoria['ID_CATEGORIA'] }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $categoria['NOMBRE_CATEGORIA'] }}</span>
                            </td>
                            <td>{{ $categoria['DESCRIPCION'] ?? 'Sin descripción' }}</td>
                            <td>
                                @if($categoria['FECHA_CREACION'])
                                    {{ date('d/m/Y', strtotime($categoria['FECHA_CREACION'])) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('categorias.edit', $categoria['ID_CATEGORIA']) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('categorias.destroy', $categoria['ID_CATEGORIA']) }}" 
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta categoría?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Eliminar
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
                <i class="bi bi-tags display-1 text-muted"></i>
                <h4 class="mt-3">No hay categorías registradas</h4>
                <p class="text-muted">Comience agregando algunas categorías para organizar los libros</p>
                <a href="{{ route('categorias.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Crear Primera Categoría
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

