FROM composer:latest AS composer

FROM php:7.4-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    # system dependency
    apt-utils \
    # composer dependency
    git \
    libzip-dev \
    # preferred by composer to unpack zip files instead as with the PHP zip extension
    unzip \
  && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) \
    # composer dependency php-zip
    zip

# install composer binary
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# php config
RUN ln -s ${PHP_INI_DIR}/php.ini-development ${PHP_INI_DIR}/php.ini

# run as non root user
USER 1000:1000
WORKDIR /opt
# set composer cache directory
ENV COMPOSER_HOME /tmp/.composer
