#!/bin/bash
set -e

cd /var/www; php artisan config:cache
env >> /var/www/.env
php-fpm7.2 -D

# add cron job into cronfile
echo "* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1" >> cronfile
# install cron job
crontab cronfile
# rm tmp file
rm cronfile

cron -f & 
nginx -g "daemon off;"
