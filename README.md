Sistema de Préstamo de Libros - Biblioteca Virtual
Tecnologías: Laravel + Oracle Database + PL/SQL
Módulos: Gestión de Libros (CRUD) y Gestión de Préstamos


Pasos para Ejecutar

1. Instalar dependencias: composer install
2. Configurar .env: Copiar .env.example a .env y configurar datos de Oracle
3. Ejecutar scripts SQL: Correr los archivos en database/scripts/ en orden numérico
4. Verificar conexión: php artisan tinker → DB::connection('oracle')->select('SELECT 1 FROM DUAL')
5. Iniciar servidor: php artisan serve
6. Acceder: http://localhost:8000





URLs Principales

Dashboard: http://localhost:8000
Libros: http://localhost:8000/libros
Préstamos: http://localhost:8000/prestamos
