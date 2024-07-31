FROM composer:2.0


# Sử dụng image php:8.0-fpm-alpine
FROM php:8.2-fpm-alpine

LABEL maintainer="DucLS <ducls.coder@gmail.com>"

ARG DEBIAN_FRONTEND=noninteractive
RUN apk add --no-cache gettext gettext-libs gettext-asprintf \
&& apk add --no-cache --virtual .build-deps gettext-dev \
&& docker-php-ext-install gettext

RUN apk add --no-cache mysql-client msmtp perl wget procps shadow libzip libpng libjpeg-turbo libwebp freetype icu

RUN apk add --no-cache --virtual build-essentials \
    icu-dev icu-libs zlib-dev g++ make automake autoconf libzip-dev \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install intl && \
    docker-php-ext-install opcache && \
    docker-php-ext-install exif && \
    docker-php-ext-install zip && \
    docker-php-ext-install bcmath


# Cài đặt những thư viện cần thiết
# RUN docker-php-ext-install \
#     bcmath \
#     gd \
#     pdo_mysql \
#     mysqli \
#     exif \
#     zip \
#     intl \
#     opcache


# Tạo thư mục /var/www/html
RUN mkdir -p /var/www/html

# Copy toàn bộ file trong thư mục ./src ở máy local vào trong thư mục /var/www/html ở trong container
COPY ./ /var/www/html

# Cài đăt composer
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer
