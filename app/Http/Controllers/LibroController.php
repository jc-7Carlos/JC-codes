<?php
// esto es archivo LibroController.php
namespace App\Http\Controllers;

use App\Services\LibroService;
use Illuminate\Http\Request;
use Exception;

class LibroController extends Controller
{
    protected $libroService;

    public function __construct(LibroService $libroService)
    {
        $this->libroService = $libroService;
    }

    public function index()
    {
        try {
            // Usar método alternativo temporalmente
            $libros = $this->libroService->listarLibrosAlternativo();
            return view('libros.index', compact('libros'));
        } catch (Exception $e) {
            // Si falla, mostrar error detallado
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $categorias = $this->libroService->listarCategorias();
            $autores = $this->libroService->listarAutores();
            return view('libros.create', compact('categorias', 'autores'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'isbn' => 'nullable|string|max:20',
            'id_autor' => 'required|integer',
            'id_categoria' => 'required|integer',
            'editorial' => 'nullable|string|max:100',
            'año_publicacion' => 'nullable|integer|min:1000|max:' . date('Y'),
            'numero_paginas' => 'nullable|integer|min:1',
            'cantidad_total' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string'
        ]);

        $resultado = $this->libroService->crearLibro($request->all());

        if ($resultado['success']) {
            return redirect()->route('libros.index')->with('success', $resultado['mensaje']);
        } else {
            return back()->with('error', $resultado['mensaje'])->withInput();
        }
    }

    public function show($id)
    {
        try {
            $libro = $this->libroService->obtenerLibro($id);
            if (!$libro) {
                return redirect()->route('libros.index')->with('error', 'Libro no encontrado');
            }
            return view('libros.show', compact('libro'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $libro = $this->libroService->obtenerLibro($id);
            if (!$libro) {
                return redirect()->route('libros.index')->with('error', 'Libro no encontrado');
            }
            $categorias = $this->libroService->listarCategorias();
            $autores = $this->libroService->listarAutores();
            return view('libros.edit', compact('libro', 'categorias', 'autores'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'isbn' => 'nullable|string|max:20',
            'id_autor' => 'required|integer',
            'id_categoria' => 'required|integer',
            'editorial' => 'nullable|string|max:100',
            'año_publicacion' => 'nullable|integer|min:1000|max:' . date('Y'),
            'numero_paginas' => 'nullable|integer|min:1',
            'cantidad_total' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string'
        ]);

        $resultado = $this->libroService->actualizarLibro($id, $request->all());

        if ($resultado['success']) {
            return redirect()->route('libros.index')->with('success', $resultado['mensaje']);
        } else {
            return back()->with('error', $resultado['mensaje'])->withInput();
        }
    }

    public function destroy($id)
    {
        $resultado = $this->libroService->eliminarLibro($id);

        if ($resultado['success']) {
            return redirect()->route('libros.index')->with('success', $resultado['mensaje']);
        } else {
            return back()->with('error', $resultado['mensaje']);
        }
    }

    public function search(Request $request)
    {
        $termino = $request->input('busqueda');

        if (empty($termino)) {
            return redirect()->route('libros.index');
        }

        try {
            // CAMBIAR ESTA LÍNEA para usar método alternativo
            $libros = $this->libroService->buscarLibros($termino);
            return view('libros.index', compact('libros', 'termino'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // API endpoints
    public function apiIndex()
    {
        try {
            $libros = $this->libroService->listarLibros();
            return response()->json(['success' => true, 'data' => $libros]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'isbn' => 'nullable|string|max:20',
            'id_autor' => 'required|integer',
            'id_categoria' => 'required|integer',
            'editorial' => 'nullable|string|max:100',
            'año_publicacion' => 'nullable|integer|min:1000|max:' . date('Y'),
            'numero_paginas' => 'nullable|integer|min:1',
            'cantidad_total' => 'required|integer|min:1',
            'ubicacion' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string'
        ]);

        $resultado = $this->libroService->crearLibro($request->all());

        return response()->json($resultado, $resultado['success'] ? 201 : 400);
    }
}
