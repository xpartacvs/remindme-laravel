FROM composer:lts AS composer
COPY . .
RUN composer install


FROM php:8.2-alpine
WORKDIR /var/www/html
COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=composer /app/vendor ./vendor
COPY --from=composer /usr/bin/composer /usr/bin/composer
EXPOSE 8080
CMD [ "php", '-a' ]


