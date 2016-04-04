### [problem]
Lo contactamos porque hemos sido informados que el **host/servidor** {{IP}} brinda servicios de DNS de manera insegura. 
En particular, la configuración de dicho servicio 
[responde consultas recursivas](https://www.us-cert.gov/ncas/alerts/TA13-088A) realizadas desde fuera de la red de la UNLP.
### [/problem]

### [derivated_problem_content]
### Problemas derivados

El *host* bajo su administración podría llegar a ser usado en ataques de
[amplificación](https://www.us-cert.gov/ncas/alerts/TA14-017A). Esto
permitiría realizar ataques a terceros de tipo:

* DoS (Denegación de servicio)
* DDoS (Denegación de servicio distribuida)

Adicionalmente, el servidor podría verse expuesto a ataques de
envenenamiento de caché de DNS o **Pharming**.
### [/derivated_problem_content]

### [verification_content]
### Cómo verificar el problema

Utilizando el comando:
### [destacated]
    dig +short test.openresolver.com TXT @{{IP}}
### [/destacated]
o vía web a través de la siguiente página:
### [destacated]
    http://openresolver.com/?ip={{IP}}
### [/destacated]

### [/verification_content]
### [recomendations_content]

### Recomendaciones

Se recomienda desactivar la respuesta recursiva a consultas que no
provienen de redes bajo su administración.
### [/recomendations_content]

### [more_information_content]

### Mas información
### [destacated]
* [https://www.us-cert.gov/ncas/alerts/TA13-088A](https://www.us-cert.gov/ncas/alerts/TA13-088A)
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)

### [/destacated]
### [/more_information_content]

