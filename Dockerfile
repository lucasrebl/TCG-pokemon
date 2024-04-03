FROM php:8.1-apache

# Install additional PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite
RUN service apache2 restart