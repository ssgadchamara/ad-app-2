# Use the official PHP image as the base image
FROM php:7.4-apache

# Install the LDAP extension and other dependencies
RUN apt-get update && \
    apt-get install -y libldap2-dev && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
    docker-php-ext-install ldap

# Copy your PHP application files to the container
COPY index.php /var/www/html/

# Expose port 80 for Apache
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
