FROM php:7.4-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    mysqli \
    pdo \
    pdo_mysql \
    mbstring \
    xml \
    zip \
    opcache

# Enable Apache modules
RUN a2enmod rewrite headers ssl

# Copy custom PHP configuration
COPY docker/php.ini /usr/local/etc/php/php.ini

# Copy custom Apache configuration
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Create necessary directories and set permissions
RUN mkdir -p /var/www/html/logs \
    && mkdir -p /var/www/html/labs \
    && touch /var/www/html/labs/lab3_requests.txt \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/logs \
    && chmod -R 777 /var/www/html/labs

# Set proper permissions for log files
RUN find /var/www/html -name "*.txt" -type f -exec chmod 666 {} \; \
    && find /var/www/html -name "*.log" -type f -exec chmod 666 {} \;

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"] 
