### [problem]
Lo contactamos porque hemos sido informados que el host con {{IP}} contiene
una instalación de Memcached accesible desde Internet.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
Debido a que este servicio no provee autenticación, cualquier entidad que acceda a la instancia de Memcache, tendrá control total sobre los objetos almacenados, con lo que se podría:

* Acceder a la información almacenada
* Realizar el defacement del servidor WEB
* Realizar una denegación de servicio sobre el servidor
### [/derivated_problem_content]

### [verification_content]
### Cómo verificar el problema
Para comprobar que el servicio está abierto, utilice el comando `telnet` del siguiente modo:
### [destacated]
    telnet {{IP}} 11211
    stats items
### [/destacated]
### [/verification_content]

### [recomendations_content]
### Recomendaciones
Se recomienda alguna de las siguientes:

* Establecer reglas de firewall para denegar las consultas desde hosts/redes no autorizadas. 
### [/recomendations_content]

### [more_information_content]
### Mas información
### [destacated]
* [memcached.org] (memcached.org)
* [http://infiltrate.tumblr.com/post/38565427/hacking-memcache] (http://infiltrate.tumblr.com/post/38565427/hacking-memcache)
* [http://es.wikipedia.org/wiki/Defacement] (http://es.wikipedia.org/wiki/Defacement)
### [/destacated]
### [/more_information_content]
