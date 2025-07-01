{{-- resources/views/prestamos/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Préstamos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-journal-check"></i> Préstamos Activos</h1>
    <div>
        <a href="{{ route('prestamos.create') }}" class="btn btn-success me-2">
            <i class="bi bi-plus-circle"></i> Nuevo Préstamo
        </a>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-list"></i> Reportes
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('prestamos.historial') }}">
                    <i class="bi bi-clock-history"></i> Historial
                </a></li>
                <li><a class="dropdown-item" href="{{ route('prestamos.vencidos') }}">
                    <i class="bi bi-exclamation-triangle"></i> Vencidos
                </a></li>
            </ul>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(count($prestamosActivos) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Libro</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución</th>
                            <th>Estado</th>
                            <th>Días Retraso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestamosActivos as $prestamo)
                        <tr>
                            <td>{{ $prestamo['ID_PRESTAMO'] }}</td>
                            <td>{{ $prestamo['USUARIO'] }}</td>
                            <td>{{ $prestamo['LIBRO'] }}</td>
                            <td>{{ date('d/m/Y', strtotime($prestamo['FECHA_PRESTAMO'])) }}</td>
                            <td>{{ date('d/m/Y', strtotime($prestamo['FECHA_DEVOLUCION_ESTIMADA'])) }}</td>
                            <td>
                                @php
                                    $estado = $prestamo['ESTADO_PRESTAMO'];
                                    $badge = 'bg-success';
                                    if($estado == 'Vencido') $badge = 'bg-danger';
                                    elseif($estado == 'Por Vencer') $badge = 'bg-warning';
                                @endphp
                                <span class="badge {{ $badge }}">{{ $estado }}</span>
                            </td>
                            <td>
                                @if($prestamo['DIAS_RETRASO'] > 0)
                                    <span class="text-danger fw-bold">{{ $prestamo['DIAS_RETRASO'] }} días</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('prestamos.devolver', $prestamo['ID_PRESTAMO']) }}" 
                                       class="btn btn-sm btn-success">
                                        <i class="bi bi-check-circle"></i> Devolver
                                    </a>
                                    <a href="{{ route('prestamos.renovar', $prestamo['ID_PRESTAMO']) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-arrow-repeat"></i> Renovar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-journal-x display-1 text-muted"></i>
                <h4 class="mt-3">No hay préstamos activos</h4>
                <p class="text-muted">Todos los libros han sido devueltos</p>
            </div>
        @endif
    </div>
</div>
@endsection