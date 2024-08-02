#!/bin/sh

# Copy .env.example to .env if .env does not exist
if [ ! -f /var/www/.env ]; then
  cp /var/www/.env.example /var/www/.env
fi

# Generate the application key if it is not set
if ! grep -q "APP_KEY=base64:" /var/www/.env; then
  php artisan key:generate --force
fi

# Install composer dependencies
composer install --prefer-dist --no-scripts --no-interaction

# Run Laravel migrations (if necessary)
# php artisan migrate

# Start Laravel development server
exec php -S 0.0.0.0:8000 -t public
