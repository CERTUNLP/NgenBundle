### [problem]
Lo contactamos porque hemos sido informados que el host/servidor {{IP}} tiene el servicio Intelligent Platform Management Interface (IPMI) accesible desde Internet.
### [/problem]


### [derivated_problem_content]
### Problemas derivados
El host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente. IPMI provee acceso a bajo nivel al dispositivo, pudiendo permitir reiniciar el sistema, instalar un nuevo sistema operativo, acceder a información alojada en el sistema, etc.

### [/derivated_problem_content]


### [recomendations_content]
### Recomendaciones
Se recomienda:

* Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.
* En caso de no utilizarlo, es recomendable deshabilitar el servicio.
### [/recomendations_content]


### [more_information_content]
### Mas información
### [destacated]
* [US-CERT alert TA13-207A] (https://www.us-cert.gov/ncas/alerts/TA13-207A)
* [Dan Farmer on IPMI security issues] (http://fish2.com/ipmi/)
### [/destacated]

### [/more_information_content]
