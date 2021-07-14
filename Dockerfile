FROM php:7.4-apache

RUN apt-get update

# 1. development packages
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    nodejs \
    cron \
    g++

# 2. apache configs + document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# 4. start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql

# 5. composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html
RUN cd /var/www/html && composer install && php artisan key:generate
RUN mkdir /var/www/html/storage/app/public/tripsWallpapers
RUN mkdir /var/www/html/storage/app/public/hotelsPhotos
RUN mkdir /var/www/html/storage/app/public/ordersReports
RUN sudo chmod -R 755 /var/www/html
#RUN cd /var/www/html/public && rm -R storage
RUN cd /var/www/html && php artisan storage:link

RUN cd /var/www/html/resources/vue && nmp install && npm audit fix && npm run build

