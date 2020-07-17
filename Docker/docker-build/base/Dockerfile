FROM php:7.4-apache
MAINTAINER CERTunlp
WORKDIR "/application"
ENV APACHE_DOCUMENT_ROOT /application/ngen_basic/web
# Install selected extensions and other stuff
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -LsS http://symfony.com/installer -o /usr/local/bin/symfony \
    && chmod +x /usr/local/bin/symfony
RUN apt-get update \
    && apt-get -y  install  unzip wget curl nodejs git node-less gettext-base sed vim libzip-dev zlib1g-dev libapache2-mod-authnz-external libc-client-dev libkrb5-dev\
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
RUN if [ ! -e /usr/bin/nodejs ]; then ln -s /usr/bin/nodejs  /usr/bin/node; fi;
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN a2enmod rewrite && a2enmod proxy && a2enmod proxy_http && a2enmod authnz_external && a2enmod headers
RUN docker-php-ext-install pdo_mysql && docker-php-ext-install zip && docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install -j$(nproc) imap
RUN symfony  new ngen_basic 3.4
#La de aabajo hay que sacar la rama y usar master
RUN rm -fr /root/.composer/cache && cd /application/ngen_basic/src && git clone -b master-docker-3.4 https://github.com/CERTUNLP/NgenBundle.git

RUN cd /application/ngen_basic && cp src/NgenBundle/Resources/installer/dependencias/composer.json . && COMPOSER_MEMORY_LIMIT=-1  composer -vvvv update


CMD ["/usr/local/bin/apache2-foreground"]
