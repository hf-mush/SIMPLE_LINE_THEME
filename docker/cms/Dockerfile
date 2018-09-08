FROM php:7-apache

RUN apt-get update
RUN apt-get install -y curl unzip libpng12-dev libjpeg-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev
RUN rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr
RUN docker-php-ext-install gd mysqli opcache pdo_mysql mbstring iconv mcrypt
RUN a2enmod rewrite expires

ENV WORDPRESS_VERSION 4.9.8
RUN curl -o wordpress.tar.gz -fSL "https://ja.wordpress.org/wordpress-${WORDPRESS_VERSION}-ja.tar.gz"
RUN tar -xzf wordpress.tar.gz
RUN rm wordpress.tar.gz
RUN mv /var/www/html/wordpress /var/www/html/cms
RUN chown -R www-data:www-data /var/www/html/cms

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

COPY index.php /var/www/html/index.php
COPY .htaccess /var/www/html/.htaccess

RUN chown www-data. /var/www/html/index.php
RUN chown www-data. /var/www/html/.htaccess

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
