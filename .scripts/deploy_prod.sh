#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true

echo 'Remove Old Env File'
rm -rf .env
# Pull the latest version of the app
# git config core.sshCommand 'ssh -i ~/.ssh/cpanel'

echo 'Removed Old Env File ...'
echo 'Pulling Form Server ...'

git pull origin prodcution
#commit
# Install composer dependencies
echo 'adding new Env File'
cp .env.prod .env
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Compile npm assets
# npm run prod

# Run database migrations
php artisan migrate --force
# php artisan db:se

# Exit maintenance mode
php artisan up

echo "Deployment finished!"
