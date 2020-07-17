### Explicación

* La imagen se dividió en dos partes: 
    * la base que tiene todo lo de PHP y dependencias que es la que más demora
    * la imagen real de ngen que es śolo el código de Ngen aplicado a la base

### Construir base

Sólo hay que hacerlo si cambian los requisitos o las dependencias.

```
cd base/
docker build -t ngen-base .
```

### Construir la imagen

```
cd ../final/
docker build -t ngen-test .
```

### Construir la imagen de desarrollo con Xdebug habilitado

*  Este build es especifica para el desarrollo usando phpstorm y xdebug que es lo que usa el team de desarrolladores, problemente sea lo mismo para cualquiier ide
* Lo que hara el debugger es conectarse contra el ide y pasarle la info
 ```
iptables -I INPUT -p tcp --dport 9000 -j ACCEPT
```
* Levantando con este build ya queda instalado el xdebug, solo tenes que cambiar la ip de remote_host y cambiar el firewall de donde estas corrinedo el ide para permitir la conexion al puerto 9000 que es donde corre el debugger.
* Fuente en video: https://www.youtube.com/watch?v=J77iuOpnUm4

```
cd ../dev/
docker build -t ngen-dev .

```

### Usar la imagen en desarrollo 
 
* Modifica docker-compose-dev.yml de github 
* Construí la imagen ngen-test en tu compu
* Prende docker-compose con ella

``` 
docker-compose -f docker-compose-dev.yml up
```


## Producción

* Construir la imagen con el tag apropiado
* Subirla a dockerhub
* Modifica docker-compose.yml
* Prende docker-compose con ella

``` 
docker-compose -f docker-compose.yml up
```
