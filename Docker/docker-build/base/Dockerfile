FROM php:7.4-apache as ngen-basic
MAINTAINER CERTunlp
WORKDIR "/application"
ENV APACHE_DOCUMENT_ROOT /application/ngen_basic/web
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install dependencies
RUN apt-get update \
    && apt-get -y  install  unzip wget curl nodejs git node-less gettext-base sed vim libzip-dev zlib1g-dev libapache2-mod-authnz-external libc-client-dev libkrb5-dev\
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
RUN if [ ! -e /usr/bin/nodejs ]; then ln -s /usr/bin/nodejs  /usr/bin/node; fi;
# Install Symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv ~/.symfony/bin/symfony /usr/local/bin/symfony
RUN chmod +x /usr/local/bin/symfony
# Configure Apache
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN a2enmod rewrite && a2enmod proxy && a2enmod proxy_http && a2enmod authnz_external && a2enmod headers
# Install PHP dependencies 
RUN docker-php-ext-install pdo_mysql && docker-php-ext-install zip && docker-php-ext-configure imap --with-kerberos --with-imap-ssl && \
    docker-php-ext-install -j$(nproc) imap
# Create Symfony proyect
RUN composer create-project symfony/framework-standard-edition ngen_basic "^3.4"
# Git checkout 
RUN rm -fr /root/.composer/cache && cd /application/ngen_basic/src && git clone https://github.com/CERTUNLP/NgenBundle.git
# Composer dependecies install
RUN cd /application/ngen_basic  \
&& cp src/NgenBundle/composer.json .  \
&& COMPOSER_MEMORY_LIMIT=-1  composer -vvvv update
CMD ["/usr/local/bin/apache2-foreground"]
