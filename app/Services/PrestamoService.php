<?php
// app/Services/PrestamoService.php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Exception;

class PrestamoService
{
    public function registrarPrestamo($idUsuario, $idLibro, $diasPrestamo = 15)
    {
        try {
            $pdo = DB::connection('oracle')->getPdo();

            $stmt = $pdo->prepare("BEGIN PKG_GESTION_PRESTAMOS.SP_REGISTRAR_PRESTAMO(
                :id_usuario, :id_libro, :dias_prestamo, :resultado, :id_prestamo
            ); END;");

            $stmt->bindParam(':id_usuario', $idUsuario);
            $stmt->bindParam(':id_libro', $idLibro);
            $stmt->bindParam(':dias_prestamo', $diasPrestamo);
            $stmt->bindParam(':resultado', $resultado, \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':id_prestamo', $idPrestamo, \PDO::PARAM_INT);

            $stmt->execute();

            return [
                'success' => strpos($resultado, 'SUCCESS') === 0,
                'mensaje' => $resultado,
                'id_prestamo' => $idPrestamo
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'mensaje' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function devolverLibro($idPrestamo, $observaciones = null)
    {
        try {
            $pdo = DB::connection('oracle')->getPdo();

            $stmt = $pdo->prepare("BEGIN PKG_GESTION_PRESTAMOS.SP_DEVOLVER_LIBRO(
                :id_prestamo, :observaciones, :resultado
            ); END;");

            $stmt->bindParam(':id_prestamo', $idPrestamo);
            $stmt->bindParam(':observaciones', $observaciones);
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

    // MÉTODO ALTERNATIVO PARA LISTAR PRÉSTAMOS ACTIVOS (sin cursor)
    public function listarPrestamosActivos()
    {
        try {
            $prestamos = DB::connection('oracle')->select("
                SELECT 
                    p.id_prestamo,
                    u.nombre AS usuario,
                    l.titulo AS libro,
                    p.fecha_prestamo,
                    p.fecha_devolucion_estimada,
                    CASE 
                        WHEN p.fecha_devolucion_estimada < SYSDATE THEN 'Vencido'
                        WHEN p.fecha_devolucion_estimada - SYSDATE <= 3 THEN 'Por Vencer'
                        ELSE 'Normal'
                    END AS estado_prestamo,
                    CASE 
                        WHEN p.fecha_devolucion_estimada < SYSDATE THEN 
                            TRUNC(SYSDATE - p.fecha_devolucion_estimada)
                        ELSE 0
                    END AS dias_retraso
                FROM tbl_prestamos p
                INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                INNER JOIN tbl_libros l ON p.id_libro = l.id_libro
                WHERE p.estado = 'Activo'
                ORDER BY p.fecha_devolucion_estimada
            ");

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($prestamos as $prestamo) {
                $result[] = [
                    'ID_PRESTAMO' => isset($prestamo->id_prestamo) ? $prestamo->id_prestamo : $prestamo->ID_PRESTAMO,
                    'USUARIO' => isset($prestamo->usuario) ? $prestamo->usuario : $prestamo->USUARIO,
                    'LIBRO' => isset($prestamo->libro) ? $prestamo->libro : $prestamo->LIBRO,
                    'FECHA_PRESTAMO' => isset($prestamo->fecha_prestamo) ? $prestamo->fecha_prestamo : $prestamo->FECHA_PRESTAMO,
                    'FECHA_DEVOLUCION_ESTIMADA' => isset($prestamo->fecha_devolucion_estimada) ? $prestamo->fecha_devolucion_estimada : $prestamo->FECHA_DEVOLUCION_ESTIMADA,
                    'ESTADO_PRESTAMO' => isset($prestamo->estado_prestamo) ? $prestamo->estado_prestamo : $prestamo->ESTADO_PRESTAMO,
                    'DIAS_RETRASO' => isset($prestamo->dias_retraso) ? $prestamo->dias_retraso : $prestamo->DIAS_RETRASO
                ];
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al listar préstamos activos: ' . $e->getMessage());
        }
    }

    public function historialPrestamos($idUsuario = null)
    {
        try {
            $whereClause = $idUsuario ? "AND p.id_usuario = :id_usuario" : "";
            $params = $idUsuario ? ['id_usuario' => $idUsuario] : [];

            $prestamos = DB::connection('oracle')->select("
                SELECT 
                    p.id_prestamo,
                    u.nombre AS usuario,
                    u.email,
                    l.titulo AS libro,
                    l.isbn,
                    p.fecha_prestamo,
                    p.fecha_devolucion_estimada,
                    p.fecha_devolucion_real,
                    p.estado,
                    p.multa,
                    p.observaciones
                FROM tbl_prestamos p
                INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                INNER JOIN tbl_libros l ON p.id_libro = l.id_libro
                WHERE 1=1 $whereClause
                ORDER BY p.fecha_prestamo DESC
            ", $params);

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($prestamos as $prestamo) {
                $result[] = [
                    'ID_PRESTAMO' => isset($prestamo->id_prestamo) ? $prestamo->id_prestamo : $prestamo->ID_PRESTAMO,
                    'USUARIO' => isset($prestamo->usuario) ? $prestamo->usuario : $prestamo->USUARIO,
                    'EMAIL' => isset($prestamo->email) ? $prestamo->email : $prestamo->EMAIL,
                    'LIBRO' => isset($prestamo->libro) ? $prestamo->libro : $prestamo->LIBRO,
                    'ISBN' => isset($prestamo->isbn) ? $prestamo->isbn : $prestamo->ISBN,
                    'FECHA_PRESTAMO' => isset($prestamo->fecha_prestamo) ? $prestamo->fecha_prestamo : $prestamo->FECHA_PRESTAMO,
                    'FECHA_DEVOLUCION_ESTIMADA' => isset($prestamo->fecha_devolucion_estimada) ? $prestamo->fecha_devolucion_estimada : $prestamo->FECHA_DEVOLUCION_ESTIMADA,
                    'FECHA_DEVOLUCION_REAL' => isset($prestamo->fecha_devolucion_real) ? $prestamo->fecha_devolucion_real : $prestamo->FECHA_DEVOLUCION_REAL,
                    'ESTADO' => isset($prestamo->estado) ? $prestamo->estado : $prestamo->ESTADO,
                    'MULTA' => isset($prestamo->multa) ? $prestamo->multa : $prestamo->MULTA,
                    'OBSERVACIONES' => isset($prestamo->observaciones) ? $prestamo->observaciones : $prestamo->OBSERVACIONES
                ];
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al obtener historial: ' . $e->getMessage());
        }
    }

    public function prestamosUsuario($idUsuario)
    {
        try {
            $prestamos = DB::connection('oracle')->select("
                SELECT 
                    p.id_prestamo,
                    l.titulo,
                    l.isbn,
                    p.fecha_prestamo,
                    p.fecha_devolucion_estimada,
                    p.fecha_devolucion_real,
                    p.estado,
                    p.multa,
                    CASE 
                        WHEN p.estado = 'Activo' AND p.fecha_devolucion_estimada < SYSDATE THEN 'Vencido'
                        WHEN p.estado = 'Activo' THEN 'Activo'
                        ELSE p.estado
                    END AS estado_actual
                FROM tbl_prestamos p
                INNER JOIN tbl_libros l ON p.id_libro = l.id_libro
                WHERE p.id_usuario = :id_usuario
                ORDER BY p.fecha_prestamo DESC
            ", ['id_usuario' => $idUsuario]);

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($prestamos as $prestamo) {
                $result[] = [
                    'ID_PRESTAMO' => isset($prestamo->id_prestamo) ? $prestamo->id_prestamo : $prestamo->ID_PRESTAMO,
                    'TITULO' => isset($prestamo->titulo) ? $prestamo->titulo : $prestamo->TITULO,
                    'ISBN' => isset($prestamo->isbn) ? $prestamo->isbn : $prestamo->ISBN,
                    'FECHA_PRESTAMO' => isset($prestamo->fecha_prestamo) ? $prestamo->fecha_prestamo : $prestamo->FECHA_PRESTAMO,
                    'FECHA_DEVOLUCION_ESTIMADA' => isset($prestamo->fecha_devolucion_estimada) ? $prestamo->fecha_devolucion_estimada : $prestamo->FECHA_DEVOLUCION_ESTIMADA,
                    'FECHA_DEVOLUCION_REAL' => isset($prestamo->fecha_devolucion_real) ? $prestamo->fecha_devolucion_real : $prestamo->FECHA_DEVOLUCION_REAL,
                    'ESTADO' => isset($prestamo->estado) ? $prestamo->estado : $prestamo->ESTADO,
                    'MULTA' => isset($prestamo->multa) ? $prestamo->multa : $prestamo->MULTA,
                    'ESTADO_ACTUAL' => isset($prestamo->estado_actual) ? $prestamo->estado_actual : $prestamo->ESTADO_ACTUAL
                ];
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al obtener préstamos del usuario: ' . $e->getMessage());
        }
    }

    public function prestamosVencidos()
    {
        try {
            // Actualizar estados vencidos primero
            DB::connection('oracle')->update("
                UPDATE tbl_prestamos 
                SET estado = 'Vencido'
                WHERE estado = 'Activo' AND fecha_devolucion_estimada < SYSDATE
            ");

            $prestamos = DB::connection('oracle')->select("
                SELECT 
                    p.id_prestamo,
                    u.nombre AS usuario,
                    u.email,
                    u.telefono,
                    l.titulo AS libro,
                    p.fecha_prestamo,
                    p.fecha_devolucion_estimada,
                    TRUNC(SYSDATE - p.fecha_devolucion_estimada) AS dias_retraso,
                    (TRUNC(SYSDATE - p.fecha_devolucion_estimada) * 2) AS multa_calculada
                FROM tbl_prestamos p
                INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                INNER JOIN tbl_libros l ON p.id_libro = l.id_libro
                WHERE p.estado = 'Vencido'
                ORDER BY p.fecha_devolucion_estimada
            ");

            // Convertir a array manejando mayúsculas
            $result = [];
            foreach ($prestamos as $prestamo) {
                $result[] = [
                    'ID_PRESTAMO' => isset($prestamo->id_prestamo) ? $prestamo->id_prestamo : $prestamo->ID_PRESTAMO,
                    'USUARIO' => isset($prestamo->usuario) ? $prestamo->usuario : $prestamo->USUARIO,
                    'EMAIL' => isset($prestamo->email) ? $prestamo->email : $prestamo->EMAIL,
                    'TELEFONO' => isset($prestamo->telefono) ? $prestamo->telefono : $prestamo->TELEFONO,
                    'LIBRO' => isset($prestamo->libro) ? $prestamo->libro : $prestamo->LIBRO,
                    'FECHA_PRESTAMO' => isset($prestamo->fecha_prestamo) ? $prestamo->fecha_prestamo : $prestamo->FECHA_PRESTAMO,
                    'FECHA_DEVOLUCION_ESTIMADA' => isset($prestamo->fecha_devolucion_estimada) ? $prestamo->fecha_devolucion_estimada : $prestamo->FECHA_DEVOLUCION_ESTIMADA,
                    'DIAS_RETRASO' => isset($prestamo->dias_retraso) ? $prestamo->dias_retraso : $prestamo->DIAS_RETRASO,
                    'MULTA_CALCULADA' => isset($prestamo->multa_calculada) ? $prestamo->multa_calculada : $prestamo->MULTA_CALCULADA
                ];
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al obtener préstamos vencidos: ' . $e->getMessage());
        }
    }

    public function renovarPrestamo($idPrestamo, $diasAdicionales = 15)
    {
        try {
            $pdo = DB::connection('oracle')->getPdo();

            $stmt = $pdo->prepare("BEGIN PKG_GESTION_PRESTAMOS.SP_RENOVAR_PRESTAMO(
                :id_prestamo, :dias_adicionales, :resultado
            ); END;");

            $stmt->bindParam(':id_prestamo', $idPrestamo);
            $stmt->bindParam(':dias_adicionales', $diasAdicionales);
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
}
