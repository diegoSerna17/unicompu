FROM php:8.3-apache

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl

# Apache rewrite (IMPORTANTE)
RUN a2enmod rewrite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permisos críticos Laravel
RUN chmod -R 777 storage bootstrap/cache

# Apache apunta a /public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf

# Optimizar Laravel (PROD)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan view:clear || true

# Puerto
EXPOSE 80

CMD ["apache2-foreground"]