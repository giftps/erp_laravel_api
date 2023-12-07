#!/bin/bash

cd /var/www/ses_api

# php artisan migrate:fresh --seed
sleep 10

# rm -Rf storage/framework
# mkdir storage/framework
# mkdir storage/framework/cache
# mkdir storage/framework/cache/data
# mkdir storage/framework/cache/laravel-excel

# mkdir storage/framework/sessions
# mkdir storage/framework/testing
# mkdir storage/framework/views

# rm -Rf storage/logs
# mkdir storage/logs
# touch storage/logs/laravel.log

chown -R www-data:www-data storage
chown -R www-data:www-data vendor

# php artisan migrate --force
# php artisan passport:install
php artisan cache:clear
php artisan storage:link
php artisan optimize
php artisan config:cache

/usr/bin/supervisord -c /etc/supervisord.conf