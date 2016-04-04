### [problem]
Le contactamos porque se nos ha informado que el *host* con IP {{IP}} tiene una base de datos MongoDB NoSQL accesible sin restricciones desde Internet.
### [/problem]
### [derivated_problem_content]

### Problemas derivados

El *host* bajo su administración podría llegar a estar brindando información sensible, comprometiendo sistemas que corren él.

### [/derivated_problem_content]
### [verification_content]

### Cómo verificar el problema

Para testear manualmente la conexión al servicio puede utilizar el comando:
### [destacated]
    mongo {{IP}}
### [/destacated]

### [/verification_content]
### [recomendations_content]

### Recomendaciones

* [Agregar](http://docs.mongodb.org/manual/core/security-network/#firewalls)
firewalls para restringir accesos no autorizados.
* [Habilitar](http://docs.mongodb.org/manual/core/authorization/)
la autenticación de accesos.
* [Habilitar](http://docs.mongodb.org/manual/core/security-network/#nohttpinterface
) el servicio con SSL.
* [Habilitar](http://docs.mongodb.org/manual/reference/security/#userAdminAnyDatabase) la autorización de acciones basada en roles.
* [Configurar](http://docs.mongodb.org/manual/core/security-network/#bind-ip)
las conexiones en la interfaz de loopback.
* Alternativamente, se puede [cambiar](http://docs.mongodb.org/manual/core/security-network/#port) el puerto de conexión.
* [Deshabilitar](http://docs.mongodb.org/manual/core/security-network/#nohttpinterface) la interfaz http de estado.
* [Deshabilitar](http://docs.mongodb.org/manual/core/security-network/#rest)
la interfaz REST.

### [/recomendations_content]
