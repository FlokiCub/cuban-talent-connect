FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y libpq-dev zip unzip
RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

# Verificar conexión a la base de datos
RUN echo "=== Verificando conexión a la base de datos ==="
RUN php artisan tinker --execute="try { DB::connection()->getPdo(); echo '✅ Conexión a DB exitosa\n'; } catch (Exception \$e) { echo '❌ Error de conexión: ' . \$e->getMessage() . '\n'; exit(1); }"

# Verificar migraciones pendientes
RUN echo "=== Estado de migraciones ==="
RUN php artisan migrate:status

# Ejecutar migraciones con verbose
RUN echo "=== Ejecutando migraciones ==="
RUN php artisan migrate --force -v

# Verificar tablas creadas
RUN echo "=== Verificando tablas en la base de datos ==="
RUN php artisan tinker --execute="\$tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = ?', ['public']); echo 'Tablas existentes: ' . count(\$tables) . '\n'; foreach (\$tables as \$table) { echo ' - ' . \$table->table_name . '\n'; }"

RUN php artisan storage:link

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
