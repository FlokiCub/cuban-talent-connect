FROM php:8.2-apache

WORKDIR /var/www/html

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar document root de Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Mostrar errores de PHP en logs
RUN echo "display_errors = stderr" >> /usr/local/etc/php/conf.d/error-logging.ini
RUN echo "log_errors = On" >> /usr/local/etc/php/conf.d/error-logging.ini

# Copiar aplicación
COPY . .

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Configurar aplicación (con errores visibles)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan key:generate --force || true
RUN php artisan storage:link || true

# Solo intentar migrar si la base de datos está disponible
RUN php artisan migrate --force || echo "Migration failed, continuing..."

EXPOSE 80

CMD ["apache2-foreground"]
