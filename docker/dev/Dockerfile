FROM php:8.0-apache

RUN apt-get update && apt-get install -y libmcrypt-dev \
    default-mysql-client libxml2-dev rsync libmagickwand-dev --no-install-recommends \
    && pecl install mcrypt-1.0.4 imagick \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install tokenizer pdo_mysql xml gd soap \
    && docker-php-ext-enable mcrypt imagick

# Development tools
RUN pecl install -f xdebug-3.1 \
    && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install -y git zip unzip    

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin/ \
    && mv /usr/local/bin/composer.phar /usr/local/bin/composer \
    && php -r "unlink('composer-setup.php');" 

EXPOSE 80

WORKDIR /var/www

COPY --chown=www-data:www-data . /var/www

RUN cp -rf /var/www/docker/000-default.conf /etc/apache2/sites-enabled/000-default.conf \
    && cp -rf /var/www/docker/dev/php.ini /usr/local/etc/php/php.ini \
    && cp -rf /var/www/docker/start.sh /usr/local/bin/start

RUN ln -s /var/www/storage/app/public /var/www/public/storage

RUN chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

# Normally CMD ["apache2-foreground"] but we want to add queue and schedule capabilities to this image
CMD ["/usr/local/bin/start"]
