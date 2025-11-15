# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# 1. Install PHP extensions
# This command installs the pdo_mysql extension required for database connectivity.
RUN docker-php-ext-install pdo_mysql

# 2. Configure Apache
# Set the web root to the /public directory.
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache's rewrite module for potential future use (e.g., clean URLs).
RUN a2enmod rewrite

# 3. Copy application files
# Copy the entire project content into the container's web root.
COPY . /var/www/html/

# 4. Set permissions
# Ensure the web server has the necessary permissions to write to files and directories if needed.
# This is generally good practice, though not strictly required for this app's current functionality.
RUN chown -R www-data:www-data /var/www/html

# 5. Expose port
# The Apache image exposes port 80 by default, so this is for documentation.
EXPOSE 80
