#!/bin/bash

# Create labs directory if it doesn't exist
mkdir -p /var/www/html/labs

# Create log files with proper permissions
touch /var/www/html/labs/lab1_requests.txt
touch /var/www/html/labs/lab2_requests.txt
touch /var/www/html/labs/lab3_requests.txt
touch /var/www/html/labs/xss1_requests.txt
touch /var/www/html/labs/xss2_requests.txt

# Set proper permissions
chown -R www-data:www-data /var/www/html/labs
chmod -R 777 /var/www/html/labs
chmod 666 /var/www/html/labs/*.txt

# Create logs directory if it doesn't exist
mkdir -p /var/www/html/logs
chown -R www-data:www-data /var/www/html/logs
chmod -R 777 /var/www/html/logs

# Start Apache
exec apache2-foreground 