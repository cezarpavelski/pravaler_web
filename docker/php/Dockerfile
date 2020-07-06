FROM php:7.4-fpm

RUN apt-get update
RUN apt-get install -y apt-utils
RUN apt-get install -y build-essential

RUN apt-get install -yq \
    libonig-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libjpeg-dev \
    libicu-dev \
    libpng-dev \
    libzip-dev

RUN docker-php-ext-install \
    pdo_mysql \
    gd \
    mbstring \
    mysqli \
    zip

RUN pecl install xdebug-2.9.5 && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get -y install vim && apt-get -y install git
