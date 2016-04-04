### [problem]

Se detectó que el servidor {{IP}} posiblemente ha sido atacado mediante la
vulnerabilidad de OpenSSL conocida como
"[Heartbleed](http://heartbleed.com/)".

### [/problem]

### [derivated_problem_content]
### Problemas derivados

Esta vulnerabilidad permite a un atacante leer la memoria de un servidor o
un cliente, permitiéndole por ejemplo, conseguir las claves privadas SSL de
un servidor.

### [/derivated_problem_content]


### [verification_content]
### Cómo verificar el problema
Para comprobar que el servicio es vulnerable, acceda al siguiente sitio
web y siga las instrucciones. 
### [destacated]
    https://filippo.io/Heartbleed/
### [/destacated]
### [/verification_content]

### [recomendations_content]
### Recomendaciones

Se recomienda actualizar de forma inmediata la librería OpenSSL del
servidor y reiniciar los servicios que hagan uso de ésta. La vulnerabilidad
"Heartbleed" permite leer fragmentos de la memoria del servicio
vulnerable. Por este motivo, es posible que el certificado SSL haya sido
comprometido y por lo tanto se recomienda regenerarlo.

### [/recomendations_content]

### [more_information_content]
### Mas información
### [destacated]
* [https://www.openssl.org/news/secadv_20140407.txt](https://www.openssl.org/news/secadv_20140407.txt)
### [/destacated]

### [/more_information_content]
