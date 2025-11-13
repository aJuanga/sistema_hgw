<?php

// Script para verificar la base de datos y tablas
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "🔍 Verificando conexión a la base de datos...\n\n";
    
    $config = config('database.connections.pgsql');
    echo "📋 Configuración:\n";
    echo "   Host: {$config['host']}\n";
    echo "   Puerto: {$config['port']}\n";
    echo "   Base de datos: {$config['database']}\n";
    echo "   Usuario: {$config['username']}\n\n";
    
    $pdo = new PDO(
        "pgsql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
        $config['username'],
        $config['password']
    );
    
    echo "✅ ¡Conexión exitosa!\n\n";
    
    // Verificar si la base de datos existe
    $stmt = $pdo->query("SELECT current_database()");
    $dbName = $stmt->fetchColumn();
    echo "📦 Base de datos actual: $dbName\n\n";
    
    // Listar todas las tablas
    echo "📊 Tablas en la base de datos:\n";
    echo str_repeat("-", 50) . "\n";
    
    $stmt = $pdo->query("
        SELECT table_name 
        FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_type = 'BASE TABLE'
        ORDER BY table_name
    ");
    
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "❌ NO HAY TABLAS en la base de datos.\n";
        echo "   Necesitas ejecutar: php artisan migrate\n";
    } else {
        echo "✅ Se encontraron " . count($tables) . " tablas:\n\n";
        foreach ($tables as $index => $table) {
            echo "   " . ($index + 1) . ". $table\n";
        }
    }
    
    echo "\n" . str_repeat("-", 50) . "\n";
    
    // Verificar tabla de migraciones
    $stmt = $pdo->query("SELECT COUNT(*) FROM migrations");
    $migrationCount = $stmt->fetchColumn();
    echo "\n📝 Migraciones registradas: $migrationCount\n";
    
} catch (PDOException $e) {
    echo "❌ ERROR de conexión:\n";
    echo "   " . $e->getMessage() . "\n\n";
    
    if (strpos($e->getMessage(), 'no existe la base de datos') !== false) {
        echo "💡 SOLUCIÓN:\n";
        echo "   1. Abre pgAdmin\n";
        echo "   2. Conecta al servidor (puerto {$config['port']})\n";
        echo "   3. Crea la base de datos: {$config['database']}\n";
        echo "   4. Ejecuta: php artisan migrate\n";
    }
}



