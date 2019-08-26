### ¿Cómo se distribuye?

* Usted puede instalar NGEN desde composer directamente, pero es un mecanismo tedioso y complicado, por lo tanto **NO RECOMENDADO** salvo que por algún motivo en particular necesite hacerlo. La URL del paquete es https://packagist.org/packages/certunlp/ngen-bundle

* Lo más simple y **RECOMENDADO** es utilizar la imagen en Docker de la app y de todas sus dependencias. 

### Se requiere:

* Docker y Docker compose 

### Pasos:
* Clonar este repo y posicionarse dentro de él:
  * `git clone https://github.com/CERTUNLP/NgenBundle.git && cd NgenBundle/Docker/`

* Para correr los contenedores y sus servicios:
  * `docker-compose up` 
  * `docker-compose up -d` (Background)

* Acceder desde el navegador de nuestra pc a http://localhost:8000
 * Usuario/password: demo/demo

* Para detener los contenedor, ejecutar:
  * `docker-compose stop` o `Ctrl+c` en la misma terminal donde se levanto

### Desarrolladores:

* Alternativamente puede utilizar montaje local del código en lugar de la imagen en si, para ello debe utilizar el file docker-compose-dev.yml
  * `docker-compose -f docker-compose-dev.yml up`
* Una vez levante el soft ya puede modificar directamente lo que esta en la carpeta que clono. Tenga en cuenta a la hora de problar cambios utilizar la aplicación con del debug habilitado.
  *  http://localhost:8000/app_dev.php

### Producción:

* Para poner en producción el sistema es recomendable verificar las variables del docker-compose.yml y ajustar aquellas que considere necesarias

### Componentes:

* NGEN: Apache + php + symfony
 * URL: http://localhost:8000
 
* BDD: MySQL
 * mysql -p 8002

* ElasticSearch:
 * port 9002

* Grafana (via proxy nginx): 
 * https://localhost/grafana

* MailCatcher:
 * http://localhost:8001
