FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-mysql php-curl wget curl nodejs\
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install ngen
#RUN cd /application\ && composer require certunlp/ngen-bundle && composer update


MAINTAINER CERTunlp

ENV ROOT /root

COPY files/app_dev.php $ROOT
COPY .env $ROOT
COPY files/install.es.sh $ROOT

RUN chmod +x $ROOT/install.es.sh; \
  bash $ROOT/install.es.sh

COPY files/entrypoint.sh $ROOT/entrypoint.sh
RUN chmod +x $ROOT/entrypoint.sh;\
  bash $ROOT/entrypoint.sh
