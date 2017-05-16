### [problem]
Lo contactamos porque hemos sido informados que el host/servidor {{IP}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “DROP”.

Dicha RPZ, consiste de bloques de red bogons, que fueron robados o liberados para generar spam u operaciones criminales.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
Es probable que su dispositivo se encuentre comprometido.
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
Se recomienda aislar el host hasta verificar y solucionar el problema.
### [/recomendations_content]
