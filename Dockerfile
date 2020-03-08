FROM php:7.2-apache

# Copy static HTML pages (when building a new image)
COPY . /var/www/html
