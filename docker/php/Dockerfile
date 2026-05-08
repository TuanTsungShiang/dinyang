FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    icu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm

RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql gd exif pcntl bcmath intl zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
