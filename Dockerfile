FROM ghcr.io/99linesofcode/php:8.1

COPY --chown=abc:users . /app/
