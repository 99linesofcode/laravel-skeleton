# syntax=docker/dockerfile:1

ARG PACKAGE_VERSION="1.1.0"
ARG BASE_IMAGE="dunglas/frankenphp:${PACKAGE_VERSION}"

FROM ${BASE_IMAGE}

LABEL org.opencontainers.image.authors="99linesofcode@gmail.com"

ARG APP_URL

ENV SERVER_NAME=${APP_URL}

RUN install-php-extensions \
  intl \
  pdo_pgsql \
  pdo_mysql \
  zip \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini;

COPY . /app
