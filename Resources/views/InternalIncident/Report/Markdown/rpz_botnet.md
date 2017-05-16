### [problem]
Lo contactamos porque hemos sido informados que el host/servidor {{IP}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ "BOTNET".

Dicha RPZ, contiene direcciones de red conocidas que están vinculadas a infraestructas de botnets. Es probable que cualquier dispositivo que esté intentando acceder a este cualquiera de los dominios incluidos en esta RPZ se encuentre comprometido y conteniendo algún tipo de malware.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
Esto indica que es probable que su servidor esté comprometido y que esté intentando conectarse a un servidor de C&C para esperar instrucciones.
### [/derivated_problem_content]

### [verification_content]
### Cómo verificar el problema
Puede verificar las conexiones establecidas con el comando "netstat".

### [destacated]
* netstat -ntulp
### [/destacated]

También verificar tráfico inusual con Wireshark como así también los procesos ejecutándose en el host.
### [/verification_content]

### [recomendations_content]
### Recomendaciones
Se recomienda aislar el host de la red hasta verificar y solucionar el problema.
### [/recomendations_content]
