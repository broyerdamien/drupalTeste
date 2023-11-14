FROM php:8.2-apache

ENV TIMEZONE Europe/Paris

RUN apt-get update && \
    apt-get install -y \
        mariadb-client \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libssl-dev \
        libcurl4-openssl-dev \
        locales \
        locales-all \
        pkg-config \
        gnupg \
        unzip \
        git && \
    docker-php-ext-configure gd --with-jpeg  &&  \
    docker-php-ext-install -j$(nproc) gd curl && \
    docker-php-ext-install mysqli pdo_mysql && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache bcmath && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && \
    echo "${TIMEZONE}" > /etc/timezone && \
    locale-gen fr_FR.UTF-8

RUN curl -sS https://getcomposer.org/installer -o /root/composer-setup.php && php /root/composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -

RUN apt-get install -y nodejs

RUN echo 'export PATH="/var/www/drupal/vendor/bin:$PATH"' >> ~/.bashrc

COPY 000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/drupal/web
