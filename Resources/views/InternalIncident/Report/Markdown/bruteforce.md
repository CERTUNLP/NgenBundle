### [problem]

Se detectaron ataques de fuerza bruta provenientes del host {{IP}}, los cuales probablemente se deban a que el equipo ha sido comprometido.

### [/problem]

### [derivated_problem_content]
### Problemas derivados

Este tipo de ataques suelen estar vinculados a un malware que busca infectar otros dispositivos, de la red o no, o a un atacante que utiliza el mismo para realizar un reconocimiento de la red.
En cualquiera de los dos casos, existen consecuencias directas de su realización:

* Consumo excesivo del ancho de banda por parte del host
* Compromiso de otros equipos
* etc

### [/derivated_problem_content]


### [verification_content]
### Cómo verificar el problema

Se puede realizar una verificación del problema a través del análisis del tráfico existente en la red o sobre el host afectado, utilizando herramientas como 
### [destacated]
    tcpdump
### [/destacated]
o 
### [destacated]
    wireshark
### [/destacated]

### [/verification_content]

### [recomendations_content]
### Recomendaciones

Adjunto le enviamos logs de conexiones para que pueda identificar la actividad maliciosa del host.
Se recomienda el filtrado del tráfico hasta que el problema se vea resultó.

### [/recomendations_content]

### [more_information_content]
### Mas información
### [destacated]
* [http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks](http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks)
### [/destacated]

### [/more_information_content]


