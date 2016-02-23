### [problem]
Le contactamos porque se nos ha informado que el *host* con IP {{IP}} tiene el servicio LDAP accesible desde Internet.
### [/problem]
### [derivated_problem_content]

### Problemas derivados

El *host* bajo su administración podría llegar a estar brindando información sensible.

### [/derivated_problem_content]


### [recomendations_content]

### Recomendaciones

* Establecer reglas de firewall para permitir consultas sólo desde las redes autorizadas. 
* Utilizar TLS en la comunicación con el servicio.
* No permitir conexiones de manera anónima (Anonymous BIND).
* [Información adicional](https://www.sans.org/reading-room/whitepapers/directories/securely-implementing-ldap-109).

### [/recomendations_content]

