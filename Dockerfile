FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpng-dev libjpeg-dev libfreetype6-dev nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --optimize-autoloader --no-interaction \
    && npm install \
    && npm run build

RUN cp .env.example .env \
    && sed -i 's/APP_ENV=local/APP_ENV=production/g' .env \
    && sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' .env \
    && sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/g' .env \
    && sed -i '/DB_HOST=/d;/DB_PORT=/d;/DB_DATABASE=/d;/DB_USERNAME=/d;/DB_PASSWORD=/d' .env \
    && touch database/database.sqlite \
    && php artisan key:generate --force

EXPOSE 10000

CMD php artisan storage:link || true && php artisan migrate:fresh --seed --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
