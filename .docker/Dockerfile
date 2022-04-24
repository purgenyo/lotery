ARG PHP_VERSION=8.1.1
ARG NGINX_VERSION=1.21
ARG TAG=latest

################## API ########################
FROM php:8.1.5-fpm as api

ARG XDEBUG_VERSION=3.1.2
ARG API_PHP_FPM_PORT=9010

RUN apt-get update && apt-get -y install cron iproute2 git zip libzip-dev zlib1g-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && docker-php-ext-install opcache zip mysqli pdo pdo_mysql

RUN rm -rf /usr/src/php/ext/xdebug \
    && git clone --branch $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install xdebug

COPY ./.docker/php/conf.d/dev /usr/local/etc/php/conf.d
COPY ./.docker/php-fpm/conf.d/dev /usr/local/etc/php/conf.d

COPY ./.docker/cron/crontab /var/spool/cron/crontabs/crontab
RUN chmod +x /var/spool/cron/crontabs/crontab && crontab /var/spool/cron/crontabs/crontab

COPY ./.docker/cron/start-cron.sh /usr/local/bin/start-cron.sh
RUN chmod +x /usr/local/bin/start-cron.sh

# Заменим дефолтный порт 9000 на выданный 9010
RUN sed -i -r "s/9000/${API_PHP_FPM_PORT}/" /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /app

COPY ./.docker/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

EXPOSE ${API_PHP_FPM_PORT}

################## NGINX ########################

FROM nginx:${TAG} as nginx

RUN apt-get update & apt-get -y install curl
COPY ./.docker/nginx/templates /etc/nginx/templates
WORKDIR /app

EXPOSE 80
