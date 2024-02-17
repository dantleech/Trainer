FROM php:7.4
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini
RUN apt-get update && apt-get install -y git
WORKDIR /app
ENTRYPOINT ["php"]
CMD ["-t","/app/web","-S","0.0.0.0:8080"]
