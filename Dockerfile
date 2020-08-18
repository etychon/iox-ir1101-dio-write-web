FROM multiarch/qemu-user-static:x86_64-aarch64 as qemu
FROM arm64v8/alpine
MAINTAINER Emmanuel Tychon <etychon@cisco.com>
LABEL Description="Web app to display and control Digital I/O ports on Cisco IR1101"

COPY --from=qemu /usr/bin/qemu-aarch64-static /usr/bin
COPY start.sh /start.sh                                                                                                                                                                


# Setup apache and php
RUN apk update && apk upgrade && apk --no-cache add \
        apache2 \
        php7-apache2 \
        php7-json


RUN sed -i "s/#LoadModule\ rewrite_module/LoadModule\ rewrite_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#LoadModule\ session_module/LoadModule\ session_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#LoadModule\ session_cookie_module/LoadModule\ session_cookie_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#LoadModule\ session_crypto_module/LoadModule\ session_crypto_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#LoadModule\ deflate_module/LoadModule\ deflate_module/" /etc/apache2/httpd.conf \
    && sed -i "s#^DocumentRoot \".*#DocumentRoot \"/app/public\"#g" /etc/apache2/httpd.conf \
    && sed -i "s#/var/www/localhost/htdocs#/app/public#" /etc/apache2/httpd.conf \
    && sed -i "s#^Listen 80#Listen 8080#" /etc/apache2/httpd.conf \
    && printf "\n<Directory \"/app/public\">\n\tAllowOverride All\n</Directory>\n" >> /etc/apache2/httpd.conf

RUN mkdir /app && mkdir /app/public && chown -R apache:apache /app && chmod -R 755 /app && mkdir bootstrap && adduser apache root

COPY ./public-html/ /app/public/

EXPOSE 8080
    
CMD [ "sh", "/start.sh" ]
