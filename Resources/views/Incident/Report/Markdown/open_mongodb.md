### [problem]
Le contactamos porque se nos ha informado que el *host* con IP {{IP}} tendría habilitada la respuesta a conexiones externas y sin control de acceso.
### [/problem]
### [derivated_problem_content]

### Problemas derivados

El *host* bajo su administración podría llegar a estar brindando información sensible, ofreciendo un servicio de forma abierta y comprometiendo todos los sistemas corriendo en el mismo.

### Cómo verificar el problema

Para testear manualmente si el servicio es vulnerable a esta falla puede
utilizar el comando:
### [destacated]
    mongo {{IP}}
### [/destacated]

### [/verification_content]
### [recomendations_content]

### Recomendaciones

* [Habilita](http://docs.mongodb.org/manual/core/authorization/)
la autenticación de accesos.
* [Ligar](http://docs.mongodb.org/manual/core/security-network/#bind-ip)
las conexiones a 127.0.0.1.
* [Cambiar](http://docs.mongodb.org/manual/core/security-network/#port)
el puerto de conexion.
* [Habilitar](http://docs.mongodb.org/manual/core/security-network/#nohttpinterface)
SSL para evitar "MITM".
* [Habilitar](http://docs.mongodb.org/manual/reference/security/#userAdminAnyDatabase)
la autorización de acciones basada en roles.
* [Deshabilita](http://docs.mongodb.org/manual/core/security-network/#nohttpinterface)
la interfaz http de estado.
* [Deshabilita](http://docs.mongodb.org/manual/core/security-network/#rest)
la interfaz REST.
* [Agregar](http://docs.mongodb.org/manual/core/security-network/#firewalls)
firewalls para restringir otros accesos.

### [/recomendations_content]
