### [problem]
Lo contactamos porque hemos detectado que el servidor DNS con IP {{IP}}
tiene habilitada la transferencia de alguna de sus zonas, al menos desde la
red de nuestro CERT.
### [/problem]

### [derivated_problem_content]
### Problemas derivados
El host bajo su administración podría llegar a ser usado en ataques de
amplificación DNS.
### [/derivated_problem_content]

### [verification_content]
### Cómo verificar el problema
Utilizando el comando:
### [destacated]
    dig <zona>.unlp.edu.ar @{{IP}} axfr
### [/destacated]
### [/verification_content]

### [recomendations_content]
### Recomendaciones
Se recomienda establecer restricciones en el servidor DNS que permitan la
consultas de requerimiento de zona solo desde los servidores DNS secundarios.
### [/recomendations_content]

### [more_information_content]
### Mas información
### [destacated]
* [http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868](http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868)
* [http://www.esdebian.org/wiki/transferencias-zonas-bind9](http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868)

### [/destacated]

### [/more_information_content]
