# Use the official PHP image as the base
FROM php:8.1-apache

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy the current directory contents into the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Ensure Apache user can access files
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html/

# Expose port 80 for HTTP traffic
EXPOSE 80

# Start Apache server in the foreground
CMD ["apache2-foreground"]
