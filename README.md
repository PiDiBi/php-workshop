# php-workshop
already contains https://github.com/Azure/azure-sdk-for-php

dabures@msft

## php in docker
docker info
mkdir php
cd php
nano Dockerfile
 
FROM php:5.6-apache
COPY config/php.ini /usr/local/etc/php/
COPY src/ /var/www/html/
EXPOSE 80

docker build -t my-php-app .
docker run -it --rm -p 80:80 --name my-running-app my-php-app