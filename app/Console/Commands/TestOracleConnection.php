<?php
// app/Console/Commands/TestOracleConnection.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class TestOracleConnection extends Command
{
    protected $signature = 'test:oracle';
    protected $description = 'Probar conexión con Oracle Database (xepdb1)';

    public function handle()
    {
        $this->info('🔍 Probando conexión con Oracle Database (xepdb1)...');
        $this->info('Usuario: ' . env('DB_USERNAME'));
        $this->info('Service: ' . env('DB_SERVICE_NAME'));
        $this->info('Host: ' . env('DB_HOST') . ':' . env('DB_PORT'));
        $this->info('');
        
        try {
            // Probar conexión básica
            $this->info('1. Probando conexión básica...');
            $result = DB::connection('oracle')->select('SELECT SYSDATE as fecha, USER as usuario FROM DUAL');
            $this->info('✅ Conexión exitosa');
            $this->info('   - Usuario conectado: ' . $result[0]->USUARIO);
            $this->info('   - Fecha servidor: ' . $result[0]->FECHA);
            
            // Probar si existen las tablas
            $this->info('2. Verificando tablas...');
            $tables = DB::connection('oracle')->select("
                SELECT table_name 
                FROM user_tables 
                WHERE table_name IN ('TBL_LIBROS', 'TBL_PRESTAMOS', 'USUARIOS', 'CATEGORIAS', 'AUTORES')
                ORDER BY table_name
            ");
            
            if (count($tables) > 0) {
                $this->info('Tablas encontradas:');
                foreach ($tables as $table) {
                    $this->line('  ✓ ' . $table->TABLE_NAME);
                }
            } else {
                $this->warn('⚠️  No se encontraron las tablas del proyecto. Ejecuta los scripts de creación.');
            }
            
            // Probar procedimientos almacenados
            $this->info('3. Verificando paquetes PL/SQL...');
            $packages = DB::connection('oracle')->select("
                SELECT object_name, status 
                FROM user_objects 
                WHERE object_type = 'PACKAGE' 
                AND object_name LIKE 'PKG_GESTION%'
            ");
            
            if (count($packages) > 0) {
                $this->info('Paquetes PL/SQL encontrados:');
                foreach ($packages as $package) {
                    $status = $package->STATUS == 'VALID' ? '✅' : '❌';
                    $this->line("  {$status} {$package->OBJECT_NAME} ({$package->STATUS})");
                }
                
                // Probar un procedimiento si existe
                $this->info('4. Probando procedimiento...');
                try {
                    $pdo = DB::connection('oracle')->getPdo();
                    $stmt = $pdo->prepare("BEGIN PKG_GESTION_LIBROS.SP_LISTAR_CATEGORIAS(:cursor); END;");
                    $stmt->bindParam(':cursor', $cursor, \PDO::PARAM_STMT);
                    $stmt->execute();
                    
                    $categorias = [];
                    while ($row = $cursor->fetch(\PDO::FETCH_ASSOC)) {
                        $categorias[] = $row;
                    }
                    
                    $this->info('✅ Procedimientos funcionando - ' . count($categorias) . ' categorías encontradas');
                    
                } catch (Exception $e) {
                    $this->error('❌ Error al ejecutar procedimiento: ' . $e->getMessage());
                    $this->warn('   Asegúrate de haber ejecutado los scripts PL/SQL');
                }
            } else {
                $this->warn('⚠️  No se encontraron paquetes PL/SQL. Ejecuta los scripts de creación.');
            }
            
            $this->info('');
            $this->info('🎉 ¡Configuración Oracle completada exitosamente para BIBLIOTECA_VIRTUAL!');
            
        } catch (Exception $e) {
            $this->error('❌ Error de conexión: ' . $e->getMessage());
            $this->error('');
            $this->error('Posibles soluciones:');
            $this->error('1. Verificar que Oracle esté ejecutándose');
            $this->error('2. Comprobar credenciales en .env:');
            $this->error('   DB_USERNAME=tu_usuario_oracle');
            $this->error('   DB_PASSWORD=tu_password');
            $this->error('   DB_SERVICE_NAME=xepdb1');
            $this->error('3. Verificar que la base de datos xepdb1 esté disponible');
            
            return 1;
        }
        
        return 0;
    }
}
