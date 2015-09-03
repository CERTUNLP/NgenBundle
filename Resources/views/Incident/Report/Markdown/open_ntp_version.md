### [problem]
Le contactamos porque se nos ha informado que el *host* con IP {{IP}} brinda
el servicio de NTP de manera insegura. En particular, el servicio estaría
respondiendo a comandos del tipo `NTP readvar`.
### [/problem]
### [derivated_problem_content]

### Problemas derivados

El *host* bajo su administración podría llegar a ser usado en ataques de
[amplificación](https://www.us-cert.gov/ncas/alerts/TA14-017A). Esto
permitiría realizar ataques a terceros de tipo:

* DoS (Denegación de servicio)
* DDoS (Denegación de servicio distribuida)
### [/derivated_problem_content]
### [verification_content]

### Cómo verificar el problema

Para testear manualmente si el servicio es vulnerable a esta falla puede
utilizar el comando:
### [destacated]
    ntpq -c readvar [{{IP}}]
### [/destacated]

### [/verification_content]
### [recomendations_content]

### Recomendaciones

[Deshabilitar](http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html)
las consultas `NTP readvar`.
### [/recomendations_content]
