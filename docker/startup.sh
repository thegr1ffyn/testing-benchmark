#!/bin/bash

# Create necessary directories if they don't exist
mkdir -p /var/www/html/labs
mkdir -p /var/www/html/config

# Create all lab log files with proper permissions
for lab in lab1 lab2 lab3 xss1 xss2 xss3; do
    touch "/var/www/html/labs/${lab}_requests.txt"
done

# Set proper permissions for labs directory and files
chown -R www-data:www-data /var/www/html/labs
chmod -R 777 /var/www/html/labs
chmod 666 /var/www/html/labs/*.txt

# Set proper permissions for config directory
chown -R www-data:www-data /var/www/html/config
chmod -R 755 /var/www/html/config

# Create logs directory if it doesn't exist
mkdir -p /var/www/html/logs
chown -R www-data:www-data /var/www/html/logs
chmod -R 777 /var/www/html/logs

# Ensure all PHP files in labs directory are executable
find /var/www/html/labs -name "*.php" -type f -exec chmod 755 {} \;

# Ensure all directories are traversable
find /var/www/html -type d -exec chmod 755 {} \;

# Start Apache
exec apache2-foreground 