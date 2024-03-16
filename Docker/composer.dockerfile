FROM composer:2

# Setting environment variables
ENV COMPOSERGROUP=laravel
ENV COMPOSERUSER=laravel

WORKDIR /var/www/html

RUN adduser -g ${COMPOSERGROUP} -s /bin/sh -D ${COMPOSERUSER}
