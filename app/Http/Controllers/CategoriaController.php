<?php
// app/Http/Controllers/CategoriaController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class CategoriaController extends Controller
{
    public function index()
    {
        try {
            $categorias = DB::connection('oracle')->select("
                SELECT id_categoria, nombre_categoria, descripcion, fecha_creacion
                FROM categorias 
                ORDER BY nombre_categoria
            ");

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($categorias as $categoria) {
                $result[] = [
                    'ID_CATEGORIA' => isset($categoria->id_categoria) ? $categoria->id_categoria : $categoria->ID_CATEGORIA,
                    'NOMBRE_CATEGORIA' => isset($categoria->nombre_categoria) ? $categoria->nombre_categoria : $categoria->NOMBRE_CATEGORIA,
                    'DESCRIPCION' => isset($categoria->descripcion) ? $categoria->descripcion : $categoria->DESCRIPCION,
                    'FECHA_CREACION' => isset($categoria->fecha_creacion) ? $categoria->fecha_creacion : $categoria->FECHA_CREACION,
                ];
            }

            return view('categorias.index', compact('result'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:50|unique:categorias,nombre_categoria',
            'descripcion' => 'nullable|string|max:200'
        ]);

        try {
            DB::connection('oracle')->insert("
                INSERT INTO categorias (nombre_categoria, descripcion) 
                VALUES (?, ?)
            ", [
                $request->nombre_categoria,
                $request->descripcion
            ]);

            return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $categoria = DB::connection('oracle')->select("
                SELECT id_categoria, nombre_categoria, descripcion 
                FROM categorias 
                WHERE id_categoria = ?
            ", [$id]);

            if (empty($categoria)) {
                return redirect()->route('categorias.index')->with('error', 'Categoría no encontrada');
            }

            $categoriaData = $categoria[0];
            $result = [
                'ID_CATEGORIA' => isset($categoriaData->id_categoria) ? $categoriaData->id_categoria : $categoriaData->ID_CATEGORIA,
                'NOMBRE_CATEGORIA' => isset($categoriaData->nombre_categoria) ? $categoriaData->nombre_categoria : $categoriaData->NOMBRE_CATEGORIA,
                'DESCRIPCION' => isset($categoriaData->descripcion) ? $categoriaData->descripcion : $categoriaData->DESCRIPCION,
            ];

            return view('categorias.edit', compact('result'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:200'
        ]);

        try {
            // Verificar si el nombre ya existe (excluyendo la categoría actual)
            $existe = DB::connection('oracle')->select("
                SELECT COUNT(*) as total 
                FROM categorias 
                WHERE nombre_categoria = ? AND id_categoria != ?
            ", [$request->nombre_categoria, $id]);

            $total = isset($existe[0]->total) ? $existe[0]->total : $existe[0]->TOTAL;

            if ($total > 0) {
                return back()->with('error', 'Ya existe una categoría con ese nombre')->withInput();
            }

            DB::connection('oracle')->update("
                UPDATE categorias 
                SET nombre_categoria = ?, descripcion = ?
                WHERE id_categoria = ?
            ", [
                $request->nombre_categoria,
                $request->descripcion,
                $id
            ]);

            return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            // Verificar si tiene libros asociados
            $librosCount = DB::connection('oracle')->select("
                SELECT COUNT(*) as total FROM tbl_libros WHERE id_categoria = ?
            ", [$id]);

            $total = isset($librosCount[0]->total) ? $librosCount[0]->total : $librosCount[0]->TOTAL;

            if ($total > 0) {
                return back()->with('error', 'No se puede eliminar. La categoría tiene libros asociados.');
            }

            $result = DB::connection('oracle')->delete("DELETE FROM categorias WHERE id_categoria = ?", [$id]);

            if ($result) {
                return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente');
            } else {
                return back()->with('error', 'Categoría no encontrada');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
