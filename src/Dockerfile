FROM php:8.1.0-apache

RUN apt-get update && \
  apt-get install -y locales && \
  apt-get install -y libpq-dev && \
  apt-get install -y libicu-dev && \
  docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
  docker-php-ext-configure intl && \
  docker-php-ext-install pdo pdo_pgsql intl

RUN echo 'fr_FR.UTF-8 UTF-8' >> /etc/locale.gen && \
  echo 'en_US.UTF-8 UTF-8' >> /etc/locale.gen  && \
  locale-gen

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite
