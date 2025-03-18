# Use official PHP image with Apache
FROM php:8.1-apache

# Install system dependencies for PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Enable Apache modules (mod_rewrite & mod_headers)
RUN a2enmod rewrite headers

# Copy project files to Apache root directory
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache when the container starts
CMD ["apache2-foreground"]
