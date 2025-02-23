FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    curl \
    git \
    libonig-dev \
    libzip-dev \
    mariadb-client \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN docker-php-ext-install mysqli pdo pdo_mysql mbstring zip exif pcntl bcmath intl soap opcache

RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
EXPOSE 80

CMD ["apache2-foreground"]
