FROM ubuntu:trusty

MAINTAINER CERTunlp

ENV ROOT /root

RUN apt-get update && apt-get install -y wget supervisor acl vim;

COPY files/app_dev.php $ROOT
COPY .env $ROOT
COPY files/install.es.sh $ROOT

RUN chmod +x $ROOT/install.es.sh; \
  bash $ROOT/install.es.sh

COPY files/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN ln -s /etc/elasticsearch/ /usr/share/elasticsearch/config

WORKDIR /var/www/ngen/

EXPOSE 80

COPY files/entrypoint.sh $ROOT/entrypoint.sh
RUN chmod +x $ROOT/entrypoint.sh

ENTRYPOINT ["/root/entrypoint.sh", "--"]

CMD ["/usr/bin/supervisord"]
