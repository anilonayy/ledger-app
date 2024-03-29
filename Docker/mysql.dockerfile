FROM mysql:5.7

ENV MYSQL_ROOT_PASSWORD=root

ENV MYSQL_DATABASE=ledgerApp
ENV MYSQL_USER=ledgerApp
ENV MYSQL_PASSWORD=secret
ENV MYSQL_ALLOW_EMPTY_PASSWORD=no
ENV MYSQL_RANDOM_ROOT_PASSWORD=no
ENV MYSQL_HOST=localhost

EXPOSE 3306
