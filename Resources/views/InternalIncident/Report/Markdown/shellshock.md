### [problem]

Se ha detectado que el servidor con IP {{IP}} posiblemente ha sido atacado mediante la vulnerabilidad conocida como ShellShock.

### [/problem]

### [derivated_problem_content]
### Problemas derivados

Esta vulnerabilidad permite a un atacante leer la memoria de un servidor o un cliente, permitiéndole por ejemplo, conseguir las claves privadas SSL de un servidor.

### [/derivated_problem_content]


### [verification_content]
### Cómo verificar el problema
Debido a que este reporte puede ser un falso positivo, se recomienda comprobar que el host sea realmente vulnerable a ShellShock:
### [destacated]
    env x='() { :;}; echo vulnerable' bash -c "echo esto es una prueba"
### [/destacated]
Si la ejecución en bash del comando anterior imprime "vulnerable", entonces es probable que el host haya sido comprometido. 
### [/verification_content]

### [recomendations_content]
### Recomendaciones

Se recomienda actualizar bash de forma urgente y realizar un relevamiento
con el fin de comprobar que el host no contenga backdoors.

### [/recomendations_content]

### [more_information_content]
### Más información
### [destacated]
* [http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html](http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html)
### [/destacated]
### [/more_information_content]


