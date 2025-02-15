#!/bin/bash
# php artisan storage:link
# chmod -R 775 storage bootstrap/cache
chown -R 33:33 /var/www/html/storage/app/public && echo "✅ added permissions to mounted volume"
php /var/www/html/artisan filament:optimize