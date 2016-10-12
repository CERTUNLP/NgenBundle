CERT UNLP Ngen
==============

[English version](https://github.com/CERTUNLP/NgenBundle/blob/master/README.en.md)

¿Qué es?
--------

* CERT UNLP Ngen es un sistema de gestión de incidentes desarrollado para su uso en el ámbito de trabajo del CSIRT de la Universidad Nacional de La Plata, liberado posteriormente como software libre.

* Desarrollado en PHP utilizando el Framework de desarrollo Symfony en la rama 2.8, utiliza base de datos MySQL/MariDB, Kibana y ElasticSearch.

¿Para qué sirve?
----------------

* Mediante una interfaz web nos permite gestionar los incidentes de seguridad informática que afectan a nuestra constituency. 

* Facilita la tarea diaria automatizando mucha de las  tareas que antes hacíamos en forma manual.

* Se relaciona de manera automática con varias fuentes (o feeds) que alimentan al sistema reportandole incidentes, a partir de allí NGEN se encarga de resgistrar el incidente y comunicarse con el o los afectados.

* Al reportar cada incidente brinda a los afectados documentación que les permita comprender el problema y sugiere mecanismos de solución.

Extensiones
-----------

* Tiene algunas extensiones que permite integrarlo con feeds reconocidos como son: Spamhouse, Shadowserver, Shodan o Spampot.


Estado actual
-------------

[![Build Status](https://travis-ci.org/CERTUNLP/NgenBundle.svg?branch=master)](https://travis-ci.org/CERTUNLP/NgenBundle)

Documentación
-------------

La mayor parte de la documentación la encontrarán a partir de `Resources/doc/index.md`

[La Documentación](https://github.com/CERTUNLP/NgenBundle/blob/master/Resources/doc/index.es.md)

Installación
------------

Como instalarlo en [La Instalación](https://github.com/CERTUNLP/NgenBundle/blob/master/Resources/doc/index.es.md).

Licencia
--------

Este software esta regirstrado bajo la licencia GPL v3.0. Para ver la licencia:
[Resources/meta/LICENSE](https://github.com/CERTUNLP/NgenBundle/blob/master/Resources/meta/LICENSE.es)
