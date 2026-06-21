# php 8.4 and required tools
FROM php:8.4-cli

# system dependencies and php extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# copy composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# working directory
WORKDIR /app

# first copy only composer files (for cache)
COPY composer.json composer.lock ./

# install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# copy remaining code
COPY . .

# application port
EXPOSE 8000

# make start.sh executable
RUN chmod +x start.sh

# run start.sh script
CMD ["./start.sh"]