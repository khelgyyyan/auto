# Use official PHP with Apache
FROM php:8.1-apache

# Enable mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy application files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
