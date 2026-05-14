FROM php:8.2-apache

RUN apt-get update && apt-get install -y unzip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

RUN rm -f /var/www/html/.env /var/www/html/vendor/.env
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80

CMD ["bash", "-lc", "\
    set -eux; \
    a2dismod mpm_event mpm_worker || true; \
    rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.*; \
    a2enmod mpm_prefork; \
    exec apache2-foreground \
"]