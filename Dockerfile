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

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Create logs directory
RUN mkdir -p /var/www/html/logs \
    && chown -R www-data:www-data /var/www/html/logs \
    && chmod -R 777 /var/www/html/logs

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"] 