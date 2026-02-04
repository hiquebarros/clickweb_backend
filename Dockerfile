# Dockerfile multi-stage para produção otimizada
FROM php:8.2-fpm-alpine AS base

# Instalar dependências do sistema
RUN apk add --no-cache \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    sqlite-dev \
    nginx \
    supervisor \
    nodejs \
    npm

# Instalar extensões PHP
RUN docker-php-ext-install pdo pdo_sqlite pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# ==================================================
# Stage: Dependencies
# ==================================================
FROM base AS dependencies

# Copiar arquivos de dependências
COPY composer.json composer.lock ./
COPY package.json package-lock.json* ./

# Instalar dependências PHP (sem dev)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Instalar dependências Node
# RUN npm ci --only=production
RUN npm ci

# ==================================================
# Stage: Build
# ==================================================
FROM dependencies AS build

# Copiar código fonte
COPY . .

# Copiar dependências do stage anterior
#COPY --from=dependencies /var/www/html/vendor ./vendor
#COPY --from=dependencies /var/www/html/node_modules ./node_modules

# Gerar autoload otimizado
RUN composer dump-autoload --optimize --no-dev

# Build assets com Vite
RUN npm run build

# Limpar node_modules após build (não precisamos em produção)
RUN rm -rf node_modules

# ==================================================
# Stage: Production
# ==================================================
FROM base AS production

# Copiar código e dependências do build
COPY --from=build /var/www/html /var/www/html

# Criar diretórios necessários
RUN mkdir -p /var/www/html/storage/logs \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache \
    /var/www/html/bootstrap/cache

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar configurações do Nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/http.d/default.conf

# Copiar configuração do Supervisor
COPY docker/supervisord.conf /etc/supervisord.conf

# Expor porta
EXPOSE 8080

# Script de inicialização
COPY docker/start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:8080/health || exit 1

# Comando de inicialização
CMD ["/usr/local/bin/start"]
