FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    libzip-dev \
    zip \
    unzip \
    curl \
    curl-dev \
    libpng-dev \
    oniguruma-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    freetype-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql curl ftp
# To upload image
RUN mkdir -p /usr/share/nginx/html/file_upload \
    && chown -R www-data:www-data /usr/share/nginx/html/file_upload \
    && chmod 775 /usr/share/nginx/html/file_upload

# Set working directory
WORKDIR /usr/share/nginx/html/

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files 
COPY ./www /usr/share/nginx/html/

# Run composer install
RUN composer install --no-interaction

EXPOSE 9000

USER www-data
