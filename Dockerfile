FROM php:8.2-apache

RUN rm -f /etc/apache2/mods-enabled/mpm_event.conf \
          /etc/apache2/mods-enabled/mpm_event.load \
          /etc/apache2/mods-enabled/mpm_worker.conf \
          /etc/apache2/mods-enabled/mpm_worker.load \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.conf \
              /etc/apache2/mods-enabled/mpm_prefork.conf \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.load \
              /etc/apache2/mods-enabled/mpm_prefork.load \
    && docker-php-ext-install mysqli
RUN ls /etc/apache2/mods-enabled/ | grep mpm
COPY . /var/www/html/

EXPOSE 80