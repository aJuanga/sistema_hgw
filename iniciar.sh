#!/bin/bash

echo "================================================"
echo "  Iniciando Sistema HGW - Healthy Glow Wellness"
echo "================================================"
echo ""

# 1. Iniciar PostgreSQL
echo "1. Iniciando PostgreSQL..."
service postgresql start
sleep 2
echo "   ✓ PostgreSQL iniciado"
echo ""

# 2. Limpiar cachés
echo "2. Limpiando cachés de Laravel..."
php artisan optimize:clear
echo "   ✓ Cachés limpiadas"
echo ""

# 3. Mostrar información
echo "================================================"
echo "  INFORMACIÓN DE ACCESO"
echo "================================================"
echo ""
echo "CLIENTES (contraseña: password):"
echo "  - pedro@gmail.com"
echo "  - laura@gmail.com"
echo "  - roberto@gmail.com"
echo "  - sofia@gmail.com"
echo ""
echo "ADMINISTRADORES (contraseña: password):"
echo "  - jefa@healthyglow.com"
echo "  - admin@healthyglow.com"
echo ""
echo "================================================"
echo ""

# 4. Iniciar servidor
echo "3. Iniciando servidor de desarrollo..."
echo ""
echo "   🌐 Servidor disponible en: http://127.0.0.1:8001"
echo ""
echo "   Para detener el servidor presiona: Ctrl + C"
echo ""
echo "================================================"
echo ""

php artisan serve --host=127.0.0.1 --port=8001
