### [problem]
Le contactamos porque se nos ha informado que el *host* con IP {{IP}} brinda
el servicio de NTP de manera insegura. En particular, el servicio estaría
respondiendo a comandos del tipo
[NTP monlist](https://www.us-cert.gov/ncas/alerts/TA14-013A).
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

Para testear manualmente si el servicio es vulnerable a esta falla, puede
utilizar el comando:
### [destacated]
    ntpdc -n -c monlist [{{IP}}]
### [/destacated]

### [/verification_content]
### [recomendations_content]

### Recomendaciones

Las versiones de `ntpd` anteriores a la 4.2.7 son vulnerables por
defecto. Por lo tanto, lo más simple es actualizar a la última versión.

En caso de que actualizar no sea una opción, como alternativa se puede
optar por deshabilitar la funcionalidad `monlist`.
### [/recomendations_content]
### [more_information_content]

[Más](http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm)
[información](http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html)
sobre cómo deshabilitar `monlist`.
### [/more_information_content]
