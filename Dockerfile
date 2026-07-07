# === Stage 1: Build frontend assets ===
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm ci && npm run build

# === Stage 2: Install PHP dependencies ===
FROM composer:2 AS composer-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-plugins --no-scripts --ignore-platform-reqs

# === Stage 3: Production Runtime ===
FROM php:8.2-fpm-alpine AS runner
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    sqlite \
    postgresql-client \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    libxml2-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_sqlite pdo_pgsql bcmath zip opcache

# Configure PHP-FPM to listen on UNIX socket
RUN echo -e "[global]\ndaemonize = no\n\n[www]\nlisten = /var/run/php-fpm.sock\nlisten.owner = www-data\nlisten.group = www-data\nlisten.mode = 0660" > /usr/local/etc/php-fpm.d/zz-docker.conf

# Configure Nginx to run as www-data and set permissions
RUN sed -i "s/user nginx;/user www-data;/g" /etc/nginx/nginx.conf \
    && chown -R www-data:www-data /var/lib/nginx /var/log/nginx

# Configure production OPcache
RUN echo -e "opcache.enable=1\nopcache.memory_consumption=256\nopcache.max_accelerated_files=20000\nopcache.revalidate_freq=0\nopcache.validate_timestamps=0" > /usr/local/etc/php/conf.d/opcache-prod.ini

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy application files from previous stages
COPY --from=composer-builder --chown=www-data:www-data /app/vendor ./vendor
COPY --from=frontend-builder --chown=www-data:www-data /app/public/build ./public/build
COPY --chown=www-data:www-data . .

# Expose port 80
EXPOSE 80

# Run entrypoint and start supervisor
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
