### [problem]
Lo contactamos porque hemos sido informados que el host/servidor {{IP}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ "BOTNET".

Dicha RPZ, contiene direcciones de red conocidas que están vinculadas a infraestructuras de botnets.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
Es probable que su PC o servidor que esté intentando acceder a dominios de BOTNETs.

Esto indica que la misma esté comprometido con algún tipo de malware y quiera conectarse a un servidor C&C para esperar instrucciones a ejecutar (DoS, fuerza bruta, envío de spams, etc.).

### [/derivated_problem_content]
### Consideraciones

Se debe tener en cuenta que si la IP informada es un servidor de mail, este reporte podría tratarse de un falso positivo. La razón de ello es que en la detección de SPAM, se evalúan URLs observadas en los correos electrónicos.

Por otro lado, si la IP informada es un servidor de DNS (resolver local) el origen del problema no es el servidor sino el host que le hizo la consulta DNS reportada. En este caso, la manera de detectar el host infectado es registrando las consultas DNS.

### [recomendations_content]
### Recomendaciones
Se recomienda analizar el host de la red para verificar y solucionar el problema.


### [/recomendations_content]
