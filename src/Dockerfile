FROM composer:lts AS composer
COPY . .
RUN composer install


FROM php:8.2-alpine
WORKDIR /var/www/html
RUN apk add --no-cache tzdata
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql
COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=composer /app/vendor ./vendor
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN mv ./start.sh /usr/bin/start.sh
EXPOSE 8000
ENTRYPOINT ["/usr/bin/start.sh"]
