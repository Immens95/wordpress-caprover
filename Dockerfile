FROM wordpress:latest

# Rimuovi eventuali configurazioni OPcache predefinite
RUN rm -f /usr/local/etc/php/conf.d/opcache-recommended.ini
RUN rm -f /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

# Installa l'estensione Redis
RUN pecl install redis \
    && docker-php-ext-enable redis

# Installa OPcache (assicurati che sia compilato nel PHP)
RUN docker-php-ext-install opcache

# Copia la configurazione PHP personalizzata
COPY custom-php.ini /usr/local/etc/php/conf.d/zzz-custom-php.ini
COPY php.ini /usr/local/etc/php/php.ini

# Crea file dedicato OPcache ottimizzato per WordPress
RUN echo "zend_extension=opcache.so
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
opcache.validate_timestamps=1
opcache.revalidate_freq=60
opcache.fast_shutdown=1
opcache.save_comments=1
opcache.jit=0
opcache.file_cache=/tmp/opcache
opcache.file_cache_only=0
" > /usr/local/etc/php/conf.d/zzz-opcache.ini

# Assicurati che la directory per il file cache esista e sia scrivibile
RUN mkdir -p /tmp/opcache && chown www-data:www-data /tmp/opcache

# Copia wp-config personalizzato
COPY wp-config.php /usr/src/wordpress/wp-config.php
RUN chown www-data:www-data /usr/src/wordpress/wp-config.php

WORKDIR /var/www/html

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
