<?php
// Script simple para verificar la BD - ejecuta: php verificar_bd_simple.php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $pdo = DB::connection()->getPdo();
    $dbName = DB::connection()->getDatabaseName();
    
    echo "\n";
    echo "╔══════════════════════════════════════════════════════════╗\n";
    echo "║     ✅ VERIFICACIÓN DE BASE DE DATOS                      ║\n";
    echo "╚══════════════════════════════════════════════════════════╝\n\n";
    
    echo "📦 Base de datos: $dbName\n";
    echo "✅ Conexión: EXITOSA\n\n";
    
    $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_type = 'BASE TABLE' ORDER BY table_name");
    
    echo "📊 Total de tablas: " . count($tables) . "\n\n";
    echo "Lista de tablas:\n";
    echo str_repeat("─", 50) . "\n";
    
    foreach ($tables as $index => $table) {
        $tableName = $table->table_name;
        $rowCount = DB::table($tableName)->count();
        echo sprintf("  %2d. %-40s (%d registros)\n", $index + 1, $tableName, $rowCount);
    }
    
    echo str_repeat("─", 50) . "\n";
    echo "\n✅ ¡Todo está funcionando correctamente!\n";
    echo "💡 Si no ves las tablas en pgAdmin, revisa el archivo COMO_VER_TABLAS_PGADMIN.md\n\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n\n";
    echo "💡 Verifica:\n";
    echo "   1. Que PostgreSQL esté corriendo\n";
    echo "   2. Que la base de datos 'hgw_db' exista\n";
    echo "   3. Que el puerto en .env sea 5433\n\n";
}



