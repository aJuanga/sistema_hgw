# Instrucciones para crear la base de datos en PostgreSQL

## Problema
La base de datos `hgw_db` no existe en PostgreSQL, aunque las migraciones dicen estar ejecutadas.

## Solución

### Opción 1: Usar pgAdmin (Recomendado)

1. Abre pgAdmin 4
2. Conecta al servidor PostgreSQL (puerto 5433 según tu .env)
3. Haz clic derecho en "Databases" → "Create" → "Database..."
4. Nombre: `hgw_db`
5. Owner: `postgres`
6. Haz clic en "Save"

### Opción 2: Usar psql (Línea de comandos)

Abre PowerShell o CMD y ejecuta:

```bash
# Conectar a PostgreSQL
psql -h 127.0.0.1 -p 5433 -U postgres

# Ingresa la contraseña: 14107802

# Crear la base de datos
CREATE DATABASE hgw_db;

# Salir
\q
```

### Opción 3: Usar el script PowerShell

Ejecuta en PowerShell desde la carpeta del proyecto:

```powershell
.\setup_database.ps1
```

**Nota:** Asegúrate de que `psql` esté en tu PATH. Si no, usa la ruta completa:
`C:\Program Files\PostgreSQL\18\bin\psql.exe`

### Después de crear la base de datos

Una vez creada la base de datos, ejecuta las migraciones:

```bash
php artisan migrate
```

O si quieres ejecutar los seeders también:

```bash
php artisan migrate:fresh --seed
```

## Verificar en pgAdmin

1. Abre pgAdmin
2. Conecta al servidor (puerto 5433)
3. Expande "Databases"
4. Deberías ver `hgw_db` en la lista
5. Expande `hgw_db` → "Schemas" → "public" → "Tables"
6. Deberías ver todas las tablas creadas por las migraciones

## Configuración actual (.env)

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5433
DB_DATABASE=hgw_db
DB_USERNAME=postgres
DB_PASSWORD=14107802
```

**IMPORTANTE:** El puerto es 5433, no el estándar 5432. Asegúrate de conectarte al puerto correcto en pgAdmin.



