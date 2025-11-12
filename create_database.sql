-- Script para crear la base de datos hgw_db en PostgreSQL
-- Ejecutar este script en pgAdmin o psql

-- Conectarse a la base de datos postgres primero
-- Luego ejecutar:

-- Crear la base de datos si no existe
SELECT 'CREATE DATABASE hgw_db'
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'hgw_db')\gexec

-- O usar este comando directamente:
-- CREATE DATABASE hgw_db;

-- Verificar que la base de datos existe
SELECT datname FROM pg_database WHERE datname = 'hgw_db';

