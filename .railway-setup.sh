#!/bin/bash
# Script de setup automático para Railway

echo "=== INICIANDO CONFIGURACIÓN RAILWAY ==="

# Esperar a que la base de datos esté lista
echo "Esperando inicialización..."
sleep 10

# Configurar Laravel para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones
echo "Ejecutando migraciones..."
php artisan migrate --force

echo "=== CONFIGURACIÓN COMPLETADA ==="
