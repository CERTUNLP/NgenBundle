### [problem]
Lo contactamos porque hemos sido informados que el host/servidor {{IP}} está realizando consultas de DNS de dominios listados en la lista BOTNET.
La lista BOTNET, contiene IPs conocidas como servidores de C&C de botnets. Es altamente probable que cualquier maquina intentando acceder a este cualquiera de los dominios incluidos en esta lista este comprometida y conteniendo algún tipo de malware.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
Esto indica que es probable que su servidor este comprometido y que esté intentando conectarse a un servidor de C&C para esperar instrucciones.
### [/derivated_problem_content]

### [verification_content]
### Cómo verificar el problema
Puede verificar las conexiones establecidas con el comando "netstat".

### [destacated]
* netstat -ntulp
### [/destacated]

También verificar trafico inusual con Wireshark como así también los procesos ejecutándose en el host.
### [/verification_content]

### [recomendations_content]
### Recomendaciones
Se recomienda aislar el host hasta verificar y solucionar el problema.
### [/recomendations_content]
