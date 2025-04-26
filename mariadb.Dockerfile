FROM mariadb:lts-noble

ENV MYSQL_ROOT_PASSWORD=secret \
    MYSQL_DATABASE=ProBook

COPY database/AccProBook.sql /docker-entrypoint-initdb.d/

EXPOSE 3306


