FROM composer:latest AS composer

# https://www.php.net/supported-versions.php
FROM php:8.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    # system dependency \
    apt-utils \
    # composer dependency \
    git \
    # php extension ext-intl \
    libicu-dev \
    # php extension ext-zip \
    libzip-dev \
    # preferred by composer to unpack zip files instead as with the PHP zip extension \
    unzip \
  && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure \
    # php extension ext-intl \
    intl

RUN docker-php-ext-install -j$(nproc) \
    # php extension ext-bcmath \
    bcmath \
    # php extension ext-intl \
    intl \
    # php extension ext-zip \
    zip

# install composer binary
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# php config
RUN ln -s ${PHP_INI_DIR}/php.ini-development ${PHP_INI_DIR}/php.ini

# run as non root user
USER 1000:1000
WORKDIR /app

# set composer cache directory
ENV COMPOSER_HOME /app/.composer
ENV COMPOSER_ALLOW_SUPERUSER 1
