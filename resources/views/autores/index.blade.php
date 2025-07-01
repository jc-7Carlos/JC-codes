{{-- resources/views/autores/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Autores')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person-lines-fill"></i> Gestión de Autores</h1>
    <a href="{{ route('autores.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nuevo Autor
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
                            <th>Nombre Completo</th>
                            <th>Nacionalidad</th>
                            <th>Fecha Nacimiento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result as $autor)
                        <tr>
                            <td>{{ $autor['ID_AUTOR'] }}</td>
                            <td>
                                <strong>{{ $autor['NOMBRE_AUTOR'] }} {{ $autor['APELLIDO_AUTOR'] }}</strong>
                            </td>
                            <td>
                                @if($autor['NACIONALIDAD'])
                                    <span class="badge bg-info">{{ $autor['NACIONALIDAD'] }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($autor['FECHA_NACIMIENTO'])
                                    {{ date('d/m/Y', strtotime($autor['FECHA_NACIMIENTO'])) }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('autores.destroy', $autor['ID_AUTOR']) }}" 
                                      method="POST" style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar este autor?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-person-x display-1 text-muted"></i>
                <h4 class="mt-3">No hay autores registrados</h4>
                <p class="text-muted">Comience agregando algunos autores para poder registrar libros</p>
                <a href="{{ route('autores.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Crear Primer Autor
                </a>
            </div>
        @endif
    </div>
</div>
@endsection