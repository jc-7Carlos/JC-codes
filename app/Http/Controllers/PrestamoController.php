<?php

// app/Http/Controllers/PrestamoController.php
namespace App\Http\Controllers;

use App\Services\PrestamoService;
use App\Services\LibroService;
use Illuminate\Http\Request;
use Exception;

class PrestamoController extends Controller
{
    protected $prestamoService;
    protected $libroService;

    public function __construct(PrestamoService $prestamoService, LibroService $libroService)
    {
        $this->prestamoService = $prestamoService;
        $this->libroService = $libroService;
    }

    public function index()
    {
        try {
            $prestamosActivos = $this->prestamoService->listarPrestamosActivos();
            return view('prestamos.index', compact('prestamosActivos'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // En app/Http/Controllers/PrestamoController.php - método create()
    public function create()
    {
        try {
            // CAMBIAR ESTA LÍNEA
            $libros = $this->libroService->listarLibrosAlternativo(); // ← Usar método alternativo

            // Filtrar solo libros disponibles
            $libros = array_filter($libros, function ($libro) {
                return $libro['CANTIDAD_DISPONIBLE'] > 0;
            });

            return view('prestamos.create', compact('libros'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer',
            'id_libro' => 'required|integer',
            'dias_prestamo' => 'nullable|integer|min:1|max:30'
        ]);

        $diasPrestamo = $request->input('dias_prestamo', 15);
        
        $resultado = $this->prestamoService->registrarPrestamo(
            $request->id_usuario,
            $request->id_libro,
            $diasPrestamo
        );

        if ($resultado['success']) {
            return redirect()->route('prestamos.index')->with('success', $resultado['mensaje']);
        } else {
            return back()->with('error', $resultado['mensaje'])->withInput();
        }
    }

    public function devolver($id)
    {
        return view('prestamos.devolver', compact('id'));
    }

    public function procesarDevolucion(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'nullable|string|max:500'
        ]);

        $resultado = $this->prestamoService->devolverLibro($id, $request->observaciones);

        if ($resultado['success']) {
            return redirect()->route('prestamos.index')->with('success', $resultado['mensaje']);
        } else {
            return back()->with('error', $resultado['mensaje']);
        }
    }

    public function historial(Request $request)
    {
        try {
            $idUsuario = $request->input('id_usuario');
            $historial = $this->prestamoService->historialPrestamos($idUsuario);
            return view('prestamos.historial', compact('historial', 'idUsuario'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function usuario($idUsuario)
    {
        try {
            $prestamos = $this->prestamoService->prestamosUsuario($idUsuario);
            return view('prestamos.usuario', compact('prestamos', 'idUsuario'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function vencidos()
    {
        try {
            $prestamosVencidos = $this->prestamoService->prestamosVencidos();
            return view('prestamos.vencidos', compact('prestamosVencidos'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function renovar($id)
    {
        return view('prestamos.renovar', compact('id'));
    }

    public function procesarRenovacion(Request $request, $id)
    {
        $request->validate([
            'dias_adicionales' => 'required|integer|min:1|max:30'
        ]);

        $resultado = $this->prestamoService->renovarPrestamo($id, $request->dias_adicionales);

        if ($resultado['success']) {
            return redirect()->route('prestamos.index')->with('success', $resultado['mensaje']);
        } else {
            return back()->with('error', $resultado['mensaje']);
        }
    }

    // API endpoints
    public function apiRegistrarPrestamo(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|integer',
            'id_libro' => 'required|integer',
            'dias_prestamo' => 'nullable|integer|min:1|max:30'
        ]);

        $diasPrestamo = $request->input('dias_prestamo', 15);
        
        $resultado = $this->prestamoService->registrarPrestamo(
            $request->id_usuario,
            $request->id_libro,
            $diasPrestamo
        );

        return response()->json($resultado, $resultado['success'] ? 201 : 400);
    }

    public function apiDevolverLibro(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'nullable|string|max:500'
        ]);

        $resultado = $this->prestamoService->devolverLibro($id, $request->observaciones);
        
        return response()->json($resultado, $resultado['success'] ? 200 : 400);
    }

    public function apiPrestamosActivos()
    {
        try {
            $prestamos = $this->prestamoService->listarPrestamosActivos();
            return response()->json(['success' => true, 'data' => $prestamos]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiHistorial(Request $request)
    {
        try {
            $idUsuario = $request->input('id_usuario');
            $historial = $this->prestamoService->historialPrestamos($idUsuario);
            return response()->json(['success' => true, 'data' => $historial]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiPrestamosVencidos()
    {
        try {
            $vencidos = $this->prestamoService->prestamosVencidos();
            return response()->json(['success' => true, 'data' => $vencidos]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}