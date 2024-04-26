#!/bin/sh
set -e

# TODO add deploy:setup command on first deployment

php artisan deploy:finalize

exec "$@"
