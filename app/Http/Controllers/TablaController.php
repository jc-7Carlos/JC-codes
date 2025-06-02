<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TablaController extends Controller
{
    public function actualizarTabla()
    {
        try {
            DB::statement('BEGIN actualizar_tabla_b; END;');
            return back()->with('success', 'Tabla actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar la tabla: ' . $e->getMessage());
        }
    }
}
