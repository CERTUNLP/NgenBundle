### Se requiere:
* Docker:
  * Para [Ubuntu](https://docs.docker.com/engine/installation/linux/ubuntulinux/).
  * Para [Debian](https://docs.docker.com/engine/installation/linux/debian/).
* Docker compose:
  * [Link](https://docs.docker.com/compose/install/) de descarga.


### Pasos:
* Clonar este repo y posicionarse dentro de él:
  * `git clone https://gitlab.linti.unlp.edu.ar/certunlp/ngen-docker.git && cd ngen-docker/`

* Ejecutar docker-compose para crear nuestros containers (puede tardar un largo rato):
  * `docker-compose build`

* Para correr los contenedores y sus servicios:
  * `docker-compose up -d ngen_app`

* Si hubo problemas con el comando anterior (ERROR: Encountered errors while bringing up the project.), eliminar los contenedores y volver a ejecutar el comando anterior.

* Si no se ven los estilos de la aplicación, detener los contenedores y volver a levantarlo.

* Necesitaremos datos de pruebas, ejecutar los comandos por única vez luego de crear los contenedores:
  * `docker exec ngen_app php ngen_basic/app/console d:s:c --no-interaction`
  * `docker exec ngen_app php ngen_basic/app/console d:f:l --no-interaction`

* Ya tenemos nuestra imagen y contenedores corriendo con datos de prueba...

* Acceder desde el navegador de nuestra pc a http://localhost/app_dev.php/incidents/internals o http://localhost/incidents/internals.

* Para detener los contenedor, ejecutar:
  * `docker-compose stop`

* Para eliminar los contenedor:
  * `docker-compose rm -f`

* Si se quiere acceder a alguno de los contenedores y ejecutar comandos dentro de él:
  * `docker exec -it <nombre-container> bash`
