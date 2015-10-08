### [problem]
Le contactamos porque se nos informó que el *host* con IP {{IP}} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio NTP (UDP 123).
### [/problem]

### [verification_content]
### Cómo verificar el problema

Probablemente su servidor responde a comandos del tipo ***NTP readvar***  y/o a comandos ***NTP monlist***.
Para testear manualmente si el servicio responde a este tipo de consultas puede utilizar los respectivos comandos:
### [destacated]
    ntpq -c readvar [{{IP}}]
    ntpdc -n -c monlist [{{IP}}]
### [/destacated]
### [/verification_content]

### [recomendations_content]
### Recomendaciones

Para el problema ***NTP readvar***, se recomienda:
### [destacated]
[Deshabilitar](http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html)
las consultas `NTP readvar`.
### [/destacated]

Para el problema ***NTP monlist***, se recomienda:
### [destacated]
Las versiones de `ntpd` anteriores a la 4.2.7 son vulnerables por
defecto. Por lo tanto, lo más simple es actualizar a la última versión.

En caso de que actualizar no sea una opción, como alternativa se puede
optar por deshabilitar la funcionalidad `monlist`.

[Más](http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm)
[información](http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html)
sobre cómo deshabilitar `monlist`.

### [/destacated]
### [/recomendations_content]

### [more_information_content]
### Mas información
### [destacated]
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)
### [/destacated]
### [/more_information_content]
