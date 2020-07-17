FROM ngen-base
MAINTAINER CERTunlp
WORKDIR "/application"
ENV APACHE_DOCUMENT_ROOT /application/ngen_basic/web

RUN rm -fr  /application/ngen_basic/src/NgenBundle && cd /application/ngen_basic/src && git clone -b master-docker-3.4 https://github.com/CERTUNLP/NgenBundle.git
#Comente lo de abajo para no tener overhead en dev porque reinstala lo de vendor, una vez q este hay descomentarlo
#RUN cd /application/ngen_basic/src/NgenBundle && COMPOSER_VENDOR_DIR="../../vendor" COMPOSER_MEMORY_LIMIT=-1 composer -vvvv install
#RUN rm -fr /root/.composer/cache

#RUN cp /application/ngen_basic/src/NgenBundle/Resources/installer/dependencias/parameters.yml.dist  /application/ngen_basic/app/config/parameters.yml.dist
RUN cp /application/ngen_basic/src/NgenBundle/Resources/installer/dependencias/AppKernel.php /application/ngen_basic/app/
RUN cp /application/ngen_basic/src/NgenBundle/Resources/installer/dependencias/config.yml /application/ngen_basic/app/config/config.yml
RUN cp /application/ngen_basic/src/NgenBundle/Resources/installer/dependencias/services.yml /application/ngen_basic/app/config/

ADD files/000-default.conf /etc/apache2/sites-available/000-default.conf
ADD files/routing.yml /application/ngen_basic/app/config/routing.yml
ADD files/sql/base.inicial.sql /root/
ADD files/update_parameters /usr/local/bin/update_parameters
ADD files/my_entrypoint /usr/local/bin/my_entrypoint
ADD files/mailer_entrypoint /usr/local/bin/mailer_entrypoint

ENTRYPOINT ["my_entrypoint"]
CMD ["/usr/local/bin/apache2-foreground"]
