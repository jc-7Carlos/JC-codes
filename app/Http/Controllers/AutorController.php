<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class AutorController extends Controller
{
    public function index()
    {
        try {
            $autores = DB::connection('oracle')->select("
                SELECT id_autor, nombre_autor, apellido_autor, nacionalidad, fecha_nacimiento
                FROM autores 
                ORDER BY apellido_autor, nombre_autor
            ");

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($autores as $autor) {
                $result[] = [
                    'ID_AUTOR' => isset($autor->id_autor) ? $autor->id_autor : $autor->ID_AUTOR,
                    'NOMBRE_AUTOR' => isset($autor->nombre_autor) ? $autor->nombre_autor : $autor->NOMBRE_AUTOR,
                    'APELLIDO_AUTOR' => isset($autor->apellido_autor) ? $autor->apellido_autor : $autor->APELLIDO_AUTOR,
                    'NACIONALIDAD' => isset($autor->nacionalidad) ? $autor->nacionalidad : $autor->NACIONALIDAD,
                    'FECHA_NACIMIENTO' => isset($autor->fecha_nacimiento) ? $autor->fecha_nacimiento : $autor->FECHA_NACIMIENTO,
                ];
            }

            return view('autores.index', compact('result'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('autores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_autor' => 'required|string|max:100',
            'apellido_autor' => 'required|string|max:100',
            'nacionalidad' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date'
        ]);

        try {
            DB::connection('oracle')->insert("
                INSERT INTO autores (nombre_autor, apellido_autor, nacionalidad, fecha_nacimiento) 
                VALUES (?, ?, ?, ?)
            ", [
                $request->nombre_autor,
                $request->apellido_autor,
                $request->nacionalidad,
                $request->fecha_nacimiento
            ]);

            return redirect()->route('autores.index')->with('success', 'Autor creado correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            // Verificar si tiene libros asociados
            $librosCount = DB::connection('oracle')->select("
                SELECT COUNT(*) as total FROM tbl_libros WHERE id_autor = ?
            ", [$id]);

            $total = isset($librosCount[0]->total) ? $librosCount[0]->total : $librosCount[0]->TOTAL;

            if ($total > 0) {
                return back()->with('error', 'No se puede eliminar. El autor tiene libros asociados.');
            }

            DB::connection('oracle')->delete("DELETE FROM autores WHERE id_autor = ?", [$id]);

            return redirect()->route('autores.index')->with('success', 'Autor eliminado correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
