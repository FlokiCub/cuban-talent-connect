FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y libpq-dev zip unzip
RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader

# Configurar PostgreSQL directamente sin .env
RUN echo "<?php \
\$pdo = new PDO('pgsql:host=dpg-d456sgu3jp1c73ei5rp0-a.oregon-postgres.render.com;port=5432;dbname=cuban_talent', 'cuban_user', 'SdqLzK6lTPIPbJflJo71w3uWxsZN6BQO'); \
echo '✅ Conexión directa a PostgreSQL exitosa\n'; \
\$tables = \$pdo->query(\"SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'\")->fetchAll(); \
echo 'Tablas existentes: ' . count(\$tables) . '\n'; \
foreach (\$tables as \$table) { echo ' - ' . \$table['table_name'] . '\n'; } \
" | php

RUN php artisan storage:link

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
