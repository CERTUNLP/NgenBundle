
# NGEN

## ¿Qué es?

El CERTUNLP, es el CSIRT de la Universidad Nacional de La Plata y  fue constituido en el año 2008, desde ese momento hemos pasado por diversas opciones como son GLPI, RT, RITR, Redmine, MantisBT e incluso un primer intento de desarrollo propio en PHP plano, hasta llegar al actual desarrollo de NGEN, el cuál utilizamos en el misión diaria de la gestión de incidentes.

Si bien CERTUNLP NGEN nace como un sistema de gestión de incidentes desarrollado para su uso en el ámbito de trabajo del CSIRT de la Universidad Nacional de La Plata, fue liberado posteriormente como software libre.


## ¿Para qué sirve?

* Mediante una interfaz web nos permite gestionar los incidentes de seguridad informática que afectan a nuestra constituency. 

* Facilita nuestra tarea diaria automatizando muchas de las acciones asociadas que antes hacíamos de forma manual.

* Se relaciona de manera automática con varios **feeds** o fuentes de información que alimentan a NGEN reportándo incidentes. Luego de que in incidente es creado, NGEN notifica a los afectados.

* Los reportes enviados a los afectados brindan, además de la evidencia pertinente, documentación que les permita comprender el problema y sugiere mecanismos de solución.


## Feeds

Algunos feeds con los que NGEN ya fue integrado son:
* Shadowserver
* CERT.br Spampot
* Spamhaus
* Scripts que extraen información de Shodan, Censys, etc.


## Licencia

Este software esta regirstrado bajo la licencia GPL v3.0. Para ver la licencia:
[Resources/meta/LICENSE](https://github.com/CERTUNLP/NgenBundle/blob/master/Resources/meta/LICENSE.es)
