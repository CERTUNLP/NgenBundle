### [problem]
Lo contactamos porque hemos sido informados que el host/servidor {{IP}} dispone del servicio Elasticseach abierto y accesible desde Internet.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
Por defecto, este servicio no brinda ningun tipo de autenticación, lo que significa que cualquier entidad podria tener acceso instantaneo a sus datos.
### [/derivated_problem_content]

### [recomendations_content]
### Recomendaciones
Se recomienda alguna de las siguientes:

* Deshabilitar el servicio.
* Establecer reglas de firewall para denegar las consultas desde redes no autorizadas. 
### [/recomendations_content]

### [verification_content]
### Cómo verificar el problema
### [destacated]
    * curl -XGET http://[ip]:9200/
### [/destacated]   
### [/verification_content]

### [more_information_content]
### Mas información
### [destacated]
* [https://www.elastic.co/blog/found-elasticsearch-security](https://www.elastic.co/blog/found-elasticsearch-security)
### [/destacated]
### [/more_information_content]