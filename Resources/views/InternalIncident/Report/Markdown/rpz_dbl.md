### [problem]
Lo contactamos porque hemos sido informados que el host/servidor {{IP}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “DBL”.

Dicha RPZ, contiene información sobre direcciones de red que son utilizadas como distribuidores de malware, sitios que almacenan malware, redirecciones maliciosas, dominios usados como botnets, servidores de C&C y otras actividades maliciosas.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
En la mayoría de los casos puede ser un indicador de que su host está siendo utilizado para enviar spam.
### [/derivated_problem_content]

### [verification_content]
### Cómo verificar el problema
Si es el host es un servidor de correo o DNS, es importante que lo notifique al CeRT. Esto es para estudiar con mayor profundidad el caso y ver si se trata de un falso positivo o si realmente su servidor de correo está comprometido.

Si el host no es un servidor de correo ni un DNS, es muy probable que tenga algún malware y sería útil chequear los procesos corriendo en el mísmo.
### [/verification_content]

### [recomendations_content]
### Recomendaciones
Si se trata de un servidor de correo:

* Verificar la configuración del correo o si hay una cuenta comprometida.
* Verificar que nuestro host no esté listado en blacklists.
* Mejorar la infraestructura anti-spam.

### [/recomendations_content]
