CERT UNLP Ngen
=============

¿Qué es?
--------

CERT UNLP Ngen es un sistema de gestión de incidentes desarrollado para su uso en el ámbito de trabajo del CSIRT de la Universidad Nacional de La Plata, liberado posteriormente como software libre.

Desarrollado en PHP utilizando el Framework de desarrollo Symfony en la rama 2.8, utiliza base de datos MySQL/MariDB, Kibana y ElasticSearch.

¿Para qué sirve?
----------------

Mediante una interfaz web nos permite gestionar los incidentes de seguridad informática que afectan a nuestra constituency. 

Facilita la tarea diaria automatizando mucha de las  tareas que antes hacíamos en forma manual.

Se relaciona de manera automática con varias fuentes (o feeds) que alimentan al sistema reportandole incidentes, a partir de allí NGEN se encarga de resgistrar el incidente y comunicarse con el o los afectados.

Al reportar cada incidente brinda a los afectados documentación que les permita comprender el problema y sugiere mecanismos de solución.

Extensiones
-----------

Tiene algunas extensiones que permite integrarlo con feeds reconocidos como son: Spamhouse, Shadowserver, Shodan o Spampot.


Estado actual
-------------

[![Build Status](https://travis-ci.org/CERTUNLP/NgenBundle.svg?branch=master)](https://travis-ci.org/CERTUNLP/NgenBundle)
Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md`
file in this bundle:

[Read the Documentation](https://github.com/CERTUNLP/NgenBundle/blob/master/Resources/doc/index.md)

Installation
------------

All the installation instructions are located in [documentation](https://github.com/CERTUNLP/NgenBundle/blob/master/Resources/doc/index.md).

License
-------

This bundle is under the GPL v3.0 license. See the complete license in the bundle:
[Resources/meta/LICENSE](https://github.com/CERTUNLP/NgenBundle/blob/master/Resources/meta/LICENSE)
