# php-workshop
already contains https://github.com/Azure/azure-sdk-for-php

dabures@msft

##PHP7 on Azure
* download PHP7 cgi http://windows.php.net/qa/ - Non thread safe 64bit
* Unpack to PHP7 dir
* Upload PHP7 dir to /site/PHP7 of your web
* Add Extension - *.php - D:\home\site\php7\php-cgi.exe

## php in docker
```
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
```
