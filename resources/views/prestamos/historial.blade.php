{{-- resources/views/prestamos/historial.blade.php --}}
@extends('layouts.app')

@section('title', 'Historial de Préstamos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-clock-history"></i> Historial de Préstamos</h1>
    <a href="{{ route('prestamos.index') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Volver a Préstamos
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if(count($historial) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Libro</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución Est.</th>
                            <th>Fecha Devolución Real</th>
                            <th>Estado</th>
                            <th>Multa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historial as $prestamo)
                        <tr>
                            <td>{{ $prestamo['ID_PRESTAMO'] }}</td>
                            <td>{{ $prestamo['USUARIO'] }}</td>
                            <td>{{ $prestamo['LIBRO'] }}</td>
                            <td>{{ date('d/m/Y', strtotime($prestamo['FECHA_PRESTAMO'])) }}</td>
                            <td>{{ date('d/m/Y', strtotime($prestamo['FECHA_DEVOLUCION_ESTIMADA'])) }}</td>
                            <td>
                                @if($prestamo['FECHA_DEVOLUCION_REAL'])
                                    {{ date('d/m/Y', strtotime($prestamo['FECHA_DEVOLUCION_REAL'])) }}
                                @else
                                    <span class="text-muted">Pendiente</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $prestamo['ESTADO'] == 'Devuelto' ? 'bg-success' : ($prestamo['ESTADO'] == 'Vencido' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ $prestamo['ESTADO'] }}
                                </span>
                            </td>
                            <td>
                                @if($prestamo['MULTA'] > 0)
                                    <span class="text-danger fw-bold">${{ $prestamo['MULTA'] }}</span>
                                @else
                                    <span class="text-success">$0</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-clock-history display-1 text-muted"></i>
                <h4 class="mt-3">No hay historial de préstamos</h4>
                <p class="text-muted">Aún no se han registrado préstamos</p>
            </div>
        @endif
    </div>
</div>
@endsection