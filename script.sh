#!/bin/bash
ln -s /etc/apache2/sites-available/app.conf /etc/apache2/sites-enabled/
composer install
a2dissite 000-default.conf
a2ensite app.conf
a2enmod rewrite
a2dismod mpm_event && a2enmod mpm_prefork && a2enmod php7.4
npm install
npm run dev
php artisan optimize:clear
php artisan key:generate
php artisan passport:keys
php artisan migrate
php artisan db:seed

chmod -R 777 /var/www/html
chmod -R 777 /var/www/html/vendor
chmod -R 777 /var/www/html/storage
service apache2 status > /dev/null ||  service apache2 start
