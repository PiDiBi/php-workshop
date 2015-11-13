# php-workshop
use composer to instal aszure php sdk

dabures@msft

##PHP7 on Azure
* download PHP7 cgi http://windows.php.net/qa/ - Non thread safe 64bit
* Unpack to PHP7 dir
* Upload PHP7 dir to /site/PHP7 of your web
* Add Extension - *.php - D:\home\site\php7\php-cgi.exe
* edit php.ini
*  error_log=D:\home\LogFiles\php_errors.log 
*  extension_dir="D:\home\site\php7\ext\"
*  uncoment extension=php_openssl.dll

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
##App Insigts
https://github.com/microsoft/applicationinsights-php
