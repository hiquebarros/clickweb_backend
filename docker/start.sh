#!/bin/sh

set -e

echo "🚀 Starting Clickweb Backend..."

# Aguardar um momento para garantir que tudo está pronto
sleep 2

# Criar diretórios se não existirem
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/bootstrap/cache

# Ajustar permissões
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Verificar se .env existe
if [ ! -f /var/www/html/.env ]; then
    echo "⚠️  .env file not found! Copying from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Gerar APP_KEY se não existir
if ! grep -q "APP_KEY=" /var/www/html/.env || grep -q "APP_KEY=$" /var/www/html/.env; then
    echo "🔑 Generating APP_KEY..."
    php artisan key:generate --force
fi

# Executar migrations
echo "📊 Running migrations..."
php artisan migrate --force --no-interaction -vvv

# Otimizações de cache
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Application ready!"

# Iniciar Supervisor (que iniciará PHP-FPM e Nginx)
exec /usr/bin/supervisord -c /etc/supervisord.conf
