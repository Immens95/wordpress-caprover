FROM wordpress:latest

RUN rm -f /usr/local/etc/php/conf.d/opcache-recommended.ini
RUN rm -f /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Copia la configurazione PHP personalizzata
COPY custom-php.ini /usr/local/etc/php/conf.d/zzz-custom-php.ini

# Copia il wp-config personalizzato
COPY wp-config.php /usr/src/wordpress/wp-config.php

# Assicurati che il permesso sia corretto
RUN chown www-data:www-data /usr/src/wordpress/wp-config.php

WORKDIR /var/www/html

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
