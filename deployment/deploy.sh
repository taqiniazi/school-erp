#!/bin/bash

# Deployment Script
# Usage: ./deploy.sh

# Exit on error
set -e

echo "Deploying application..."

# Enter maintenance mode
(php artisan down) || true

# Update codebase
git pull origin main

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Run database migrations
php artisan migrate --force

# Seed database (only if needed, typically run manually for first time)
# php artisan db:seed --force

# Clear caches
php artisan optimize:clear

# Cache config, routes, and views
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Restart queue workers
php artisan queue:restart

# Build assets (if using Vite/Mix)
npm ci
npm run build

# Exit maintenance mode
php artisan up

echo "Deployment finished successfully!"
