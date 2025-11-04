FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar archivos del proyecto
COPY . /var/www/html

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

WORKDIR /var/www/html

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Exponer puerto
EXPOSE 80

CMD ["apache2-foreground"]
