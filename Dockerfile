FROM php:8.2-cli

WORKDIR /app

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar aplicación
COPY . .

# Establecer permisos
RUN chmod -R 775 storage bootstrap/cache

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Solo comandos esenciales (sin cache que pueda causar problemas)
RUN php artisan storage:link

# Migraciones
RUN php artisan migrate --force

EXPOSE 8000

# Usar el servidor built-in de PHP
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
