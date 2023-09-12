#!/usr/bin/env bash
echo 'Running composer'
composer global require hirak/prestissimo
composer dump-autoload
composer update
composer clear-cache
# composer install --no-dev --working-dir=/var/www/html
# composer install --no-dev
composer install --no-scripts

echo 'Caching config...'
php artisan config:cache
 
echo 'Caching routes...'
php artisan route:cache
 
echo 'Running migrations...'
php artisan migrate --force

echo 'Running npm'
npm install
npm run prod