
### [problem]
Le contactamos porque se nos informó que el *host* con IP {{IP}} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio **chargen**.
### [/problem]


### [verification_content]
### Cómo verificar el problema
El problema puede ser verificado mediante el monitoreo de red que permita observar trafico UDP hacia y desde el puerto 19.
Alternativamente puede verificarlo conectándose manualmente a dicho servicio mediante el comando:
### [destacated]
    ncat -u {{IP}} 19
### [/destacated]
### [/verification_content]

### [recomendations_content]
### Recomendaciones
Se recomienda:
### [destacated]
* Deshabilitar el servicio.
* Establecer reglas en el firewall para bloquear de forma entrante y saliente el puerto 19/UDP
### [/destacated]
### [/recomendations_content]


### [more_information_content]
### Mas información
### [destacated]
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)
### [/destacated]
### [/more_information_content]



