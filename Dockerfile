FROM dunglas/frankenphp

ENV SERVER_NAME="https://playground.99linesofcode.nl"

RUN install-php-extensions \
  intl \
  pdo_pgsql \
  pdo_mysql \
  zip \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini;

COPY ./kamal/Caddyfile /etc/caddy/Caddyfile

COPY . /app
