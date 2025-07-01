<?php
// app/Services/LibroService.php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class LibroService
{
    public function crearLibro($datos)
    {
        try {
            $pdo = DB::connection('oracle')->getPdo();

            $stmt = $pdo->prepare("BEGIN PKG_GESTION_LIBROS.SP_CREAR_LIBRO(
                :titulo, :isbn, :id_autor, :id_categoria, :editorial,
                :año_publicacion, :numero_paginas, :cantidad_total,
                :ubicacion, :descripcion, :resultado, :id_libro
            ); END;");

            $stmt->bindParam(':titulo', $datos['titulo']);
            $stmt->bindParam(':isbn', $datos['isbn']);
            $stmt->bindParam(':id_autor', $datos['id_autor']);
            $stmt->bindParam(':id_categoria', $datos['id_categoria']);
            $stmt->bindParam(':editorial', $datos['editorial']);
            $stmt->bindParam(':año_publicacion', $datos['año_publicacion']);
            $stmt->bindParam(':numero_paginas', $datos['numero_paginas']);
            $stmt->bindParam(':cantidad_total', $datos['cantidad_total']);
            $stmt->bindParam(':ubicacion', $datos['ubicacion']);
            $stmt->bindParam(':descripcion', $datos['descripcion']);
            $stmt->bindParam(':resultado', $resultado, \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':id_libro', $idLibro, \PDO::PARAM_INT);

            $stmt->execute();

            return [
                'success' => strpos($resultado, 'SUCCESS') === 0,
                'mensaje' => $resultado,
                'id_libro' => $idLibro
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'mensaje' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function listarLibros()
    {
        try {
            $pdo = DB::connection('oracle')->getPdo();

            // Preparar la llamada al procedimiento almacenado
            $stmt = $pdo->prepare("BEGIN PKG_GESTION_LIBROS.SP_LISTAR_LIBROS(:cursor); END;");

            // Crear un cursor
            $cursor = null;
            $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT);

            // Ejecutar
            $stmt->execute();

            $libros = [];

            // Obtener los datos del cursor
            if ($cursor) {
                while (($row = $cursor->fetch(\PDO::FETCH_ASSOC)) !== false) {
                    $libros[] = $row;
                }
                $cursor = null; // Limpiar el cursor
            }

            return $libros;
        } catch (\PDOException $e) {
            throw new Exception('Error de base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception('Error al listar libros: ' . $e->getMessage());
        }
    }

    // MÉTODO ALTERNATIVO AGREGADO AQUÍ
    public function listarLibrosAlternativo()
    {
        try {
            // Método directo sin procedimiento almacenado (como backup)
            $libros = DB::connection('oracle')->select("
                SELECT 
                    l.id_libro,
                    l.titulo,
                    l.isbn,
                    NVL(a.nombre_autor || ' ' || a.apellido_autor, 'Sin autor') AS autor,
                    NVL(c.nombre_categoria, 'Sin categoría') AS nombre_categoria,
                    l.editorial,
                    l.año_publicacion,
                    l.cantidad_total,
                    l.cantidad_disponible,
                    l.estado,
                    l.fecha_registro
                FROM tbl_libros l
                LEFT JOIN autores a ON l.id_autor = a.id_autor
                LEFT JOIN categorias c ON l.id_categoria = c.id_categoria
                ORDER BY l.titulo
            ");

            // Convertir a array manejando nombres en MAYÚSCULAS
            $result = [];
            foreach ($libros as $libro) {
                $result[] = [
                    'ID_LIBRO' => isset($libro->id_libro) ? $libro->id_libro : $libro->ID_LIBRO,
                    'TITULO' => isset($libro->titulo) ? $libro->titulo : $libro->TITULO,
                    'ISBN' => isset($libro->isbn) ? $libro->isbn : $libro->ISBN,
                    'AUTOR' => isset($libro->autor) ? $libro->autor : $libro->AUTOR,
                    'NOMBRE_CATEGORIA' => isset($libro->nombre_categoria) ? $libro->nombre_categoria : $libro->NOMBRE_CATEGORIA,
                    'EDITORIAL' => isset($libro->editorial) ? $libro->editorial : $libro->EDITORIAL,
                    'AÑO_PUBLICACION' => isset($libro->año_publicacion) ? $libro->año_publicacion : (isset($libro->AÑO_PUBLICACION) ? $libro->AÑO_PUBLICACION : null),
                    'CANTIDAD_TOTAL' => isset($libro->cantidad_total) ? $libro->cantidad_total : $libro->CANTIDAD_TOTAL,
                    'CANTIDAD_DISPONIBLE' => isset($libro->cantidad_disponible) ? $libro->cantidad_disponible : $libro->CANTIDAD_DISPONIBLE,
                    'ESTADO' => isset($libro->estado) ? $libro->estado : $libro->ESTADO,
                    'FECHA_REGISTRO' => isset($libro->fecha_registro) ? $libro->fecha_registro : $libro->FECHA_REGISTRO
                ];
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al listar libros (método alternativo): ' . $e->getMessage());
        }
    }

    // MÉTODO ALTERNATIVO PARA OBTENER LIBRO (sin cursor)
    public function obtenerLibro($idLibro)
    {
        try {
            $libro = DB::connection('oracle')->select("
                SELECT 
                    l.id_libro,
                    l.titulo,
                    l.isbn,
                    l.id_autor,
                    NVL(a.nombre_autor || ' ' || a.apellido_autor, 'Sin autor') AS autor,
                    l.id_categoria,
                    NVL(c.nombre_categoria, 'Sin categoría') AS nombre_categoria,
                    l.editorial,
                    l.año_publicacion,
                    l.numero_paginas,
                    l.cantidad_total,
                    l.cantidad_disponible,
                    l.ubicacion,
                    l.descripcion,
                    l.estado,
                    l.fecha_registro
                FROM tbl_libros l
                LEFT JOIN autores a ON l.id_autor = a.id_autor
                LEFT JOIN categorias c ON l.id_categoria = c.id_categoria
                WHERE l.id_libro = :id
            ", ['id' => $idLibro]);

            if (empty($libro)) {
                return null;
            }

            $libroData = $libro[0];

            // Convertir a array manejando mayúsculas
            return [
                'ID_LIBRO' => isset($libroData->id_libro) ? $libroData->id_libro : $libroData->ID_LIBRO,
                'TITULO' => isset($libroData->titulo) ? $libroData->titulo : $libroData->TITULO,
                'ISBN' => isset($libroData->isbn) ? $libroData->isbn : $libroData->ISBN,
                'ID_AUTOR' => isset($libroData->id_autor) ? $libroData->id_autor : $libroData->ID_AUTOR,
                'AUTOR' => isset($libroData->autor) ? $libroData->autor : $libroData->AUTOR,
                'ID_CATEGORIA' => isset($libroData->id_categoria) ? $libroData->id_categoria : $libroData->ID_CATEGORIA,
                'NOMBRE_CATEGORIA' => isset($libroData->nombre_categoria) ? $libroData->nombre_categoria : $libroData->NOMBRE_CATEGORIA,
                'EDITORIAL' => isset($libroData->editorial) ? $libroData->editorial : $libroData->EDITORIAL,
                'AÑO_PUBLICACION' => isset($libroData->año_publicacion) ? $libroData->año_publicacion : (isset($libroData->AÑO_PUBLICACION) ? $libroData->AÑO_PUBLICACION : null),
                'NUMERO_PAGINAS' => isset($libroData->numero_paginas) ? $libroData->numero_paginas : (isset($libroData->NUMERO_PAGINAS) ? $libroData->NUMERO_PAGINAS : null),
                'CANTIDAD_TOTAL' => isset($libroData->cantidad_total) ? $libroData->cantidad_total : $libroData->CANTIDAD_TOTAL,
                'CANTIDAD_DISPONIBLE' => isset($libroData->cantidad_disponible) ? $libroData->cantidad_disponible : $libroData->CANTIDAD_DISPONIBLE,
                'UBICACION' => isset($libroData->ubicacion) ? $libroData->ubicacion : $libroData->UBICACION,
                'DESCRIPCION' => isset($libroData->descripcion) ? $libroData->descripcion : $libroData->DESCRIPCION,
                'ESTADO' => isset($libroData->estado) ? $libroData->estado : $libroData->ESTADO,
                'FECHA_REGISTRO' => isset($libroData->fecha_registro) ? $libroData->fecha_registro : $libroData->FECHA_REGISTRO
            ];
        } catch (Exception $e) {
            throw new Exception('Error al obtener libro: ' . $e->getMessage());
        }
    }

    public function actualizarLibro($idLibro, $datos)
    {
        try {
            $pdo = DB::connection('oracle')->getPdo();

            $stmt = $pdo->prepare("BEGIN PKG_GESTION_LIBROS.SP_ACTUALIZAR_LIBRO(
                :id_libro, :titulo, :isbn, :id_autor, :id_categoria, :editorial,
                :año_publicacion, :numero_paginas, :cantidad_total,
                :ubicacion, :descripcion, :resultado
            ); END;");

            $stmt->bindParam(':id_libro', $idLibro);
            $stmt->bindParam(':titulo', $datos['titulo']);
            $stmt->bindParam(':isbn', $datos['isbn']);
            $stmt->bindParam(':id_autor', $datos['id_autor']);
            $stmt->bindParam(':id_categoria', $datos['id_categoria']);
            $stmt->bindParam(':editorial', $datos['editorial']);
            $stmt->bindParam(':año_publicacion', $datos['año_publicacion']);
            $stmt->bindParam(':numero_paginas', $datos['numero_paginas']);
            $stmt->bindParam(':cantidad_total', $datos['cantidad_total']);
            $stmt->bindParam(':ubicacion', $datos['ubicacion']);
            $stmt->bindParam(':descripcion', $datos['descripcion']);
            $stmt->bindParam(':resultado', $resultado, \PDO::PARAM_STR, 4000);

            $stmt->execute();

            return [
                'success' => strpos($resultado, 'SUCCESS') === 0,
                'mensaje' => $resultado
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'mensaje' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function eliminarLibro($idLibro)
    {
        try {
            $pdo = DB::connection('oracle')->getPdo();

            $stmt = $pdo->prepare("BEGIN PKG_GESTION_LIBROS.SP_ELIMINAR_LIBRO(:id_libro, :resultado); END;");
            $stmt->bindParam(':id_libro', $idLibro);
            $stmt->bindParam(':resultado', $resultado, \PDO::PARAM_STR, 4000);

            $stmt->execute();

            return [
                'success' => strpos($resultado, 'SUCCESS') === 0,
                'mensaje' => $resultado
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'mensaje' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    // MÉTODO ALTERNATIVO PARA BUSCAR (sin cursor)
    public function buscarLibros($termino)
    {
        try {
            $libros = DB::connection('oracle')->select("
            SELECT 
                l.id_libro,
                l.titulo,
                l.isbn,
                NVL(a.nombre_autor || ' ' || a.apellido_autor, 'Sin autor') AS autor,
                NVL(c.nombre_categoria, 'Sin categoría') AS nombre_categoria,
                l.editorial,
                l.año_publicacion,
                l.cantidad_total,
                l.cantidad_disponible,
                l.estado
            FROM tbl_libros l
            LEFT JOIN autores a ON l.id_autor = a.id_autor
            LEFT JOIN categorias c ON l.id_categoria = c.id_categoria
            WHERE UPPER(l.titulo) LIKE '%' || UPPER(:termino) || '%'
               OR UPPER(a.nombre_autor) LIKE '%' || UPPER(:termino) || '%'
               OR UPPER(a.apellido_autor) LIKE '%' || UPPER(:termino) || '%'
               OR l.isbn LIKE '%' || :termino || '%'
            ORDER BY l.titulo
        ", ['termino' => $termino]);

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($libros as $libro) {
                $result[] = [
                    'ID_LIBRO' => isset($libro->id_libro) ? $libro->id_libro : $libro->ID_LIBRO,
                    'TITULO' => isset($libro->titulo) ? $libro->titulo : $libro->TITULO,
                    'ISBN' => isset($libro->isbn) ? $libro->isbn : $libro->ISBN,
                    'AUTOR' => isset($libro->autor) ? $libro->autor : $libro->AUTOR,
                    'NOMBRE_CATEGORIA' => isset($libro->nombre_categoria) ? $libro->nombre_categoria : $libro->NOMBRE_CATEGORIA,
                    'EDITORIAL' => isset($libro->editorial) ? $libro->editorial : $libro->EDITORIAL,
                    'AÑO_PUBLICACION' => isset($libro->año_publicacion) ? $libro->año_publicacion : (isset($libro->AÑO_PUBLICACION) ? $libro->AÑO_PUBLICACION : null),
                    'CANTIDAD_TOTAL' => isset($libro->cantidad_total) ? $libro->cantidad_total : $libro->CANTIDAD_TOTAL,
                    'CANTIDAD_DISPONIBLE' => isset($libro->cantidad_disponible) ? $libro->cantidad_disponible : $libro->CANTIDAD_DISPONIBLE,
                    'ESTADO' => isset($libro->estado) ? $libro->estado : $libro->ESTADO
                ];
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error en búsqueda: ' . $e->getMessage());
        }
    }

    public function listarCategorias()
    {
        try {
            // Usar consulta directa en lugar de procedimiento
            $categorias = DB::connection('oracle')->select("
                SELECT id_categoria, nombre_categoria, descripcion
                FROM categorias
                ORDER BY nombre_categoria
            ");

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($categorias as $categoria) {
                $result[] = [
                    'ID_CATEGORIA' => isset($categoria->id_categoria) ? $categoria->id_categoria : $categoria->ID_CATEGORIA,
                    'NOMBRE_CATEGORIA' => isset($categoria->nombre_categoria) ? $categoria->nombre_categoria : $categoria->NOMBRE_CATEGORIA,
                    'DESCRIPCION' => isset($categoria->descripcion) ? $categoria->descripcion : $categoria->DESCRIPCION
                ];
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al listar categorías: ' . $e->getMessage());
        }
    }

    public function listarAutores()
    {
        try {
            // Usar consulta directa en lugar de procedimiento
            $autores = DB::connection('oracle')->select("
                SELECT 
                    id_autor, 
                    nombre_autor || ' ' || apellido_autor AS nombre_completo,
                    nacionalidad
                FROM autores
                ORDER BY apellido_autor, nombre_autor
            ");

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($autores as $autor) {
                $result[] = [
                    'ID_AUTOR' => isset($autor->id_autor) ? $autor->id_autor : $autor->ID_AUTOR,
                    'NOMBRE_COMPLETO' => isset($autor->nombre_completo) ? $autor->nombre_completo : $autor->NOMBRE_COMPLETO,
                    'NACIONALIDAD' => isset($autor->nacionalidad) ? $autor->nacionalidad : $autor->NACIONALIDAD
                ];
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al listar autores: ' . $e->getMessage());
        }
    }
}
