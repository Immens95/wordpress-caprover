FROM wordpress:latest

# Rimuovi eventuali configurazioni OPcache predefinite
RUN rm -f /usr/local/etc/php/conf.d/opcache-recommended.ini
RUN rm -f /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Installa l'estensione Redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# Copia la configurazione PHP personalizzata
COPY custom-php.ini /usr/local/etc/php/conf.d/zzz-custom-php.ini
COPY php.ini /usr/local/etc/php/php.ini

# Assicurati che la directory per il file cache esista e sia scrivibile
RUN mkdir -p /tmp/opcache && chown www-data:www-data /tmp/opcache

# Copia wp-config personalizzato
COPY wp-config.php /usr/src/wordpress/wp-config.php
RUN chown www-data:www-data /usr/src/wordpress/wp-config.php

WORKDIR /var/www/html

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
