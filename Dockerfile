FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    oniguruma-dev \
    libxml2-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache \
    xml

RUN apk add --no-cache --virtual .redis-deps autoconf g++ make && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    apk del .redis-deps

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

RUN sed -i "s/user = www-data/user = www/" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/group = www-data/group = www/" /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
