FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y libpq-dev zip unzip
RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN chmod -R 775 storage bootstrap/cache

# Crear archivo .env temporal para el build
RUN cat > .env << 'ENVFILE'
APP_NAME="Cuban Talent Connect"
APP_ENV=production
APP_DEBUG=true
APP_KEY=base64:hIiI9NxiqjAkvx9XthiXt6WTIOP6+ATxEczZWtfkRPw=
APP_URL=https://cuban-talent-connect-1.onrender.com

DB_CONNECTION=pgsql
DB_HOST=dpg-d456sgu3jp1c73ei5rp0-a.oregon-postgres.render.com
DB_PORT=5432
DB_DATABASE=cuban_talent
DB_USERNAME=cuban_user
DB_PASSWORD=SdqLzK6lTPIPbJflJo71w3uWxsZN6BQO

SESSION_DRIVER=database
SESSION_LIFETIME=120
ENVFILE

RUN composer install --no-dev --optimize-autoloader

# Verificar conexión
RUN echo "=== Verificando conexión a PostgreSQL ==="
RUN php artisan tinker --execute="try { DB::connection()->getPdo(); echo '✅ Conexión exitosa\n'; } catch (Exception \$e) { echo '❌ Error: ' . \$e->getMessage() . '\n'; }"

# Ejecutar migraciones
RUN echo "=== Ejecutando migraciones ==="
RUN php artisan migrate --force

# Verificar tablas creadas
RUN echo "=== Verificando tablas ==="
RUN php artisan tinker --execute="\$tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = ?', ['public']); echo 'Tablas: ' . count(\$tables) . '\n'; foreach (\$tables as \$table) { echo ' - ' . \$table->table_name . '\n'; }"

RUN php artisan storage:link

# Eliminar .env temporal (Render usará sus variables)
RUN rm .env

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
