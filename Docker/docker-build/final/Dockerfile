FROM ngen-base
MAINTAINER CERTunlp
WORKDIR "/application"
ENV APACHE_DOCUMENT_ROOT /application/ngen_basic/web

#RUN rm -fr  /application/ngen_basic/src/NgenBundle && cd /application/ngen_basic/src && git clone -b master-docker-3.4 https://github.com/CERTUNLP/NgenBundle.git
RUN head /application/ngen_basic/app/config/config.yml
RUN sed -i '/- { resource: security.yml }/c\'  /application/ngen_basic/app/config/config.yml
RUN head /application/ngen_basic/app/config/config.yml
RUN sed -i '/- { resource: services.yml }/c\    - { resource: "@CertUnlpNgenBundle/Resources/config/config.yml" }\n    - { resource: "@CertUnlpNgenBundle/Resources/config/security.yml" }'  /application/ngen_basic/app/config/config.yml
RUN head /application/ngen_basic/app/config/config.yml

ADD files/AppKernel.php /application/ngen_basic/app/AppKernel.php
ADD files/000-default.conf /etc/apache2/sites-available/000-default.conf
ADD files/routing.yml /application/ngen_basic/app/config/routing.yml
ADD files/sql/base.inicial.sql /root/
ADD files/my_entrypoint /usr/local/bin/my_entrypoint
ADD files/mailer_entrypoint /usr/local/bin/mailer_entrypoint
ADD files/update_entrypoint /usr/local/bin/update_entrypoint

ENTRYPOINT ["my_entrypoint"]
CMD ["/usr/local/bin/apache2-foreground"]
