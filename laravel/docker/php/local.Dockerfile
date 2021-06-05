FROM falmar/php:7.4-mysql-dev
WORKDIR /usr/share/nginx/html
COPY docker/php/php.ini /usr/local/etc/php/
