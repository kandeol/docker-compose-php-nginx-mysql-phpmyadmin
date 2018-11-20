FROM php:7-fpm

RUN apt-get update -y \
  && apt-get install -y --no-install-recommends libpq-dev \
    && docker-php-ext-install mysqli pdo_pgsql pdo_mysql 

RUN apt-get install -y \ 
libfreetype6-dev libjpeg62-turbo-dev \ 
libgd-dev libpng-dev
RUN docker-php-ext-configure gd \ 
--with-freetype-dir=/usr/include/ \ 
--with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd
