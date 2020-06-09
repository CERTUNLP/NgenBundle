# Este build es especifica para el desarrollo usando phpstorm y xdebug que es lo que usa el team de desarrolladores, problemente sea lo mismo para cualquiier ide
# Lo que hara el debugger es conectarse contra el ide y pasarle la info
# Levantando con este build ya queda instalado el xdebug, solo tenes que cambiar la ip de remote_host y cambiar el firewall de donde estas corrinedo el ide para permitir la conexion al puerto 9000 que es donde corre el debugger.
# https://www.youtube.com/watch?v=J77iuOpnUm4

FROM certunlp/ngen:0.5.0-rc13

MAINTAINER Einar Lanfranco

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_idekey=docker" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=172.25.0.1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini

