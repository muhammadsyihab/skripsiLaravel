#!/bin/bash

echo "Optimasi route cache"
php artisan route:clear
php artisan route:cache
echo "Optimasi composer no dev"
#composer install --prefer-dist --no-dev -o
echo "Optimasi config"
php artisan config:clear
php artisan config:cache
php artisan cache:clear
echo "Optimasi View"
php artisan view:cache
echo "Optimasi NPM"
#npm run prod
