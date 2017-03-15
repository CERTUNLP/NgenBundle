### [problem]
Lo contactamos porque hemos sido informados que el host/servidor {{IP}} está realizando consultas de DNS de dominios listados en la lista DBL.
La lista DBL lista los dominios que son usados como distribuidores de malware, sitios que almacenan malware, redirecciones maliciosas, dominios usados como botnets, servidores de C&C y otras actividades maliciosas.
Esta lista incluye dominios usados como fuentes de spam y generadores de spam, phishing, virus y sitios relacionados con malware.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
En la mayoría de los casos puede ser un indicador de que su host está siendo utilizado para enviar spam.
### [/derivated_problem_content]

### [verification_content]
### Cómo verificar el problema
Si es el host es un servidor de correo puede verificar la cola de correos salientes y el tamaño de la misma.
Si el host no es un servidor de correo, es muy probable que tenga algún malware y sería útil chequear los procesos corriendo en el mísmo.
### [/verification_content]

### [recomendations_content]
### Recomendaciones
Si se trata de un servidor de correo:

* Borrar de la cola los mails que sean considerados spam.
* Verificar la configuración del correo o si hay una cuenta comprometida.
* Verificar que nuestro host no esté listado en black list's.

### [/recomendations_content]
