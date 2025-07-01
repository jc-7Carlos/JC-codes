{{-- resources/views/prestamos/vencidos.blade.php --}}
@extends('layouts.app')

@section('title', 'Préstamos Vencidos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-exclamation-triangle text-danger"></i> Préstamos Vencidos</h1>
    <a href="{{ route('prestamos.index') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Volver a Préstamos
    </a>
</div>

<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Préstamos con Retraso</h5>
    </div>
    <div class="card-body">
        @if(count($prestamosVencidos) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Libro</th>
                            <th>Fecha Vencimiento</th>
                            <th>Días Retraso</th>
                            <th>Multa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestamosVencidos as $prestamo)
                        <tr class="table-danger">
                            <td>{{ $prestamo['ID_PRESTAMO'] }}</td>
                            <td>{{ $prestamo['USUARIO'] }}</td>
                            <td>{{ $prestamo['EMAIL'] }}</td>
                            <td>{{ $prestamo['LIBRO'] }}</td>
                            <td>{{ date('d/m/Y', strtotime($prestamo['FECHA_DEVOLUCION_ESTIMADA'])) }}</td>
                            <td>
                                <span class="badge bg-danger">{{ $prestamo['DIAS_RETRASO'] }} días</span>
                            </td>
                            <td>
                                <span class="text-danger fw-bold">${{ $prestamo['MULTA_CALCULADA'] }}</span>
                            </td>
                            <td>
                                <a href="{{ route('prestamos.devolver', $prestamo['ID_PRESTAMO']) }}" 
                                   class="btn btn-sm btn-success">
                                    <i class="bi bi-check-circle"></i> Devolver
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle"></i>
                <strong>Total de préstamos vencidos:</strong> {{ count($prestamosVencidos) }}<br>
                <strong>Multa total acumulada:</strong> ${{ array_sum(array_column($prestamosVencidos, 'MULTA_CALCULADA')) }}
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-check-circle display-1 text-success"></i>
                <h4 class="mt-3 text-success">¡No hay préstamos vencidos!</h4>
                <p class="text-muted">Todos los préstamos están al día</p>
            </div>
        @endif
    </div>
</div>
@endsection