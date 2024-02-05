FROM dunglas/frankenphp

ENV SERVER_NAME=:80

RUN install-php-extensions \
  intl \
  pdo_pgsql \
  pdo_mysql \
  zip \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini;

COPY . /app
