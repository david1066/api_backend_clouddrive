#!/bin/bash
echo "Ejecutando script pre-build..."

# Instalar dependencias de sistema si es necesario
apt-get update -y
apt-get install -y libpng-dev

# Configuración adicional
export APP_ENV=production
echo "Configuración completada"

echo "Verificando la versión de Composer..."
composer --version
