FROM php:8.2-apache
RUN a2dismod mpm_event mpm_worker mpm_prefork 2>/dev/null; \
    a2enmod mpm_prefork && \
    docker-php-ext-install mysqli
COPY . /var/www/html/
EXPOSE 80