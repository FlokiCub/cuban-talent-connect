FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm

RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node.js y compilar assets
RUN npm install
RUN npm run build

# Configurar permisos
RUN chmod -R 775 storage bootstrap/cache

# Crear archivo .env temporal para el build
RUN cat > .env << 'ENVEOF'
APP_NAME="Cuban Talent Connect"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:hIiI9NxiqjAkvx9XthiXt6WTIOP6+ATxEczZWtfkRPw=
APP_URL=https://cuban-talent-connect-1.onrender.com

DB_CONNECTION=pgsql
DB_HOST=dpg-d456sgu3jp1c73ei5rp0-a.oregon-postgres.render.com
DB_PORT=5432
DB_DATABASE=cuban_talent
DB_USERNAME=cuban_user
DB_PASSWORD=SdqLzK6lTPIPbJflJo71w3uWxsZN6BQO

SESSION_DRIVER=database
ENVEOF

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
