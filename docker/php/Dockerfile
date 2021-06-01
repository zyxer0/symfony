FROM php:7.4-fpm

RUN docker-php-ext-install pdo_mysql

RUN apt-get upgrade && apt-get update && ACCEPT_EULA=Y && apt-get install -y \
    git\
    zip\
    unzip