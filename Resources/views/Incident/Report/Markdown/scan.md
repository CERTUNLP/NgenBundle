### [problem]
Nos comunicamos con Ud. para comunicarle que el host {{IP}} se encuentra realizando un proceso de Scan sobre otros equipos de la UNLP y/o el exterior.
### [/problem]

### [derivated_problem_content]
### Problemas derivados

La realización del proceso de Scan probablemente se deba a que el equipo se encuentre comprometido y siendo utilizado para reconocer otros equipos de la red, los cuales dependiendo del scan, serán luego atacados o no.
Por otro lado este problema genera la circulación en la red grandes volúmenes de información que generan problemas o pérdidas velocidad en la misma.

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

Se recomienda quitar el acceso del host afectado a la red durante la realización del análisis que determine el origen del tráfico.
Habiendo ocurrido una muy probable obtención de privilegios sobre el host por parte de atacantes, se recomienda la realización de una forencia sobre el equipo con el objetivo de determinar la vulnerabilidad que proporcionó dichos privilegios.
### [/recomendations_content]

### [more_information_content]

### Mas información
### [destacated]
* [http://archive.oreilly.com/pub/h/1393](http://archive.oreilly.com/pub/h/1393)
* [http://inai.de/documents/Chaostables.pdf](http://inai.de/documents/Chaostables.pdf)

### [/destacated]
### [/more_information_content]



