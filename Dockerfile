FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD apache2-foreground