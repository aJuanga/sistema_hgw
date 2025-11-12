# Script PowerShell para crear la base de datos PostgreSQL
# Asegúrate de que PostgreSQL esté corriendo en el puerto 5433

$env:PGPASSWORD = "14107802"
$host = "127.0.0.1"
$port = "5433"
$user = "postgres"
$database = "hgw_db"

Write-Host "Verificando conexión a PostgreSQL..." -ForegroundColor Yellow

# Verificar si la base de datos existe
$checkDb = & "psql" -h $host -p $port -U $user -d postgres -tAc "SELECT 1 FROM pg_database WHERE datname='$database'"

if ($checkDb -eq "1") {
    Write-Host "La base de datos '$database' ya existe." -ForegroundColor Green
} else {
    Write-Host "Creando la base de datos '$database'..." -ForegroundColor Yellow
    & "psql" -h $host -p $port -U $user -d postgres -c "CREATE DATABASE $database;"
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "Base de datos '$database' creada exitosamente!" -ForegroundColor Green
    } else {
        Write-Host "Error al crear la base de datos. Verifica que PostgreSQL esté corriendo y las credenciales sean correctas." -ForegroundColor Red
        exit 1
    }
}

Write-Host "Verificando tablas..." -ForegroundColor Yellow
& "psql" -h $host -p $port -U $user -d $database -c "\dt"

Write-Host "`n¡Base de datos lista!" -ForegroundColor Green

