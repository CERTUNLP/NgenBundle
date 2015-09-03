### [problem]
Le contactamos porque se nos informó que el *host* con IP {IP} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio SNMP (UDP 161).
### [/problem]


### [verification_content]
### Cómo verificar el problema
Mediante el monitoreo de red debería observar grandes cantidades de tráfico UDP correspondientes a consultas SNMP spoofeadas recibidas.
### [/verification_content]

### [recomendations_content]
### Recomendaciones
Se recomienda:

* Deshabilitar el servicio.
* Establecer reglas en el firewall para denegar las consultas desde redes no autorizadas. 
* No usar la "comunidad" por defecto. 
### [/recomendations_content]


### [more_information_content]
### Mas información
### [destacated]
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)
### [/destacated]
### [/more_information_content]

