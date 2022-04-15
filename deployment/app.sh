#!/bin/bash

for dir in "storage" "storage/framework" \
    "storage/framework/cache" "storage/framework/cache/data" \
    "storage/framework/sessions" \
    "storage/framework/testing" \
    "storage/framework/views" \
    "storage/app" "storage/app/public" \
    "storage/logs"
do
    if [[ ! -d "$dir" ]]; then
        mkdir "$dir"
    fi
done

if [[ ! -f .env ]]; then
    cp .env.example .env
fi

if [[ ! -d vendor ]]; then
    composer install --no-progress
fi

chown -R www-data:www-data storage bootstrap

chmod a+rx /var/www/deployment/wait-for-it.sh
bash /var/www/deployment/wait-for-it.sh -t 30 -s wallet_database:3306 -- echo "Database available, continuing."

php artisan migrate --force
php artisan key:generate

php artisan config:cache
php artisan route:cache

exec php-fpm
