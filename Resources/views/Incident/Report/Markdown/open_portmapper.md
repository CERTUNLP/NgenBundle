### [problem]
Lo contactamos porque hemos sido informados que el **host/servidor** {{IP}} brinda servicios de Portmapper accesibles desde Internet.
### [/problem]

### [derivated_problem_content]
### Problemas derivados

El *host* bajo su administración podría llegar a ser usado en ataques de
[amplificación](https://www.us-cert.gov/ncas/alerts/TA14-017A). Esto
permitiría realizar ataques a terceros de tipo:

* DoS (Denegación de servicio)
* DDoS (Denegación de servicio distribuida)

Adicionalmente, el servidor podría exponer otros servicios mal configurados como puede ser carpetas compartidas NFS.

### [/derivated_problem_content]

### [verification_content]
### Cómo verificar el problema

Utilizando el comando:
### [destacated]
    rpcinfo -T udp -p {{IP}}
### [/destacated]
Y ver carpetas compartidas NFS utilizando el comando:
### [destacated]
    showmount -e {{IP}}
### [/destacated]

### [/verification_content]
### [recomendations_content]

### Recomendaciones

* Se recomienda desactivar el servicio Portmapper.

* En caso de usar carpetas compartidas NFS evaluar la necesidad. Desactivar, configurar o filtrar adecuadamente.

### [/recomendations_content]

### [more_information_content]

### Mas información
### [destacated]
* [https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132](https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132)
* [http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/](http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/)
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)

### [/destacated]
### [/more_information_content]

