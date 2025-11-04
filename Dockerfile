FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y libpq-dev zip unzip
RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN chmod -R 775 storage bootstrap/cache

# Crear archivo .env temporal para el build con las variables de PostgreSQL
RUN echo "APP_NAME=Laravel" > .env
RUN echo "APP_ENV=production" >> .env
RUN echo "APP_DEBUG=true" >> .env
RUN echo "APP_KEY=base64:hIiI9NxiqjAkvx9XthiXt6WTIOP6+ATxEczZWtfkRPw=" >> .env
RUN echo "APP_URL=https://cuban-talent-connect-1.onrender.com" >> .env
RUN echo "DB_CONNECTION=pgsql" >> .env
RUN echo "DB_HOST=dpg-d456sgu3jp1c73ei5rp0-a.oregon-postgres.render.com" >> .env
RUN echo "DB_PORT=5432" >> .env
RUN echo "DB_DATABASE=cuban_talent" >> .env
RUN echo "DB_USERNAME=cuban_user" >> .env
RUN echo "DB_PASSWORD=SdqLzK6lTPIPbJflJo71w3uWxsZN6BQO" >> .env

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

# Eliminar el .env temporal (Render usará sus propias variables)
RUN rm .env

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
