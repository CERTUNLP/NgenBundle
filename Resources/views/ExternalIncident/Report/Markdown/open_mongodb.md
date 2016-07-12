### [problem]
We would like to inform you that we have been informed that the *host* {{IP}} has a database (MongoDB) with unrestricted access from the Internet.

### [/problem]
### [derivated_problem_content]

### Related issues
The *host* under your administration could be compromising sensitive information.
### [/derivated_problem_content]
### [verification_content]

### How to verify the issue

To manually verify the connection to the service, use the following command:
### [destacated]
    mongo {{IP}}
### [/destacated]

### [/verification_content]
### [recomendations_content]

### Recommendations

*TODO: Cambiar en castellano y agregar links*
* Establish firewall rules to filter unauthorized access.
* Enable Access Control and Enforce Authentication
* Configure Role-Based Access Control
* Run MongoDB with Secure Configuration Options
* Enable Secure Sockets Layer (SSL) to encrypt communications.
* Use the loopback address to establish connections to limit exposure.
* Modify the default port.
* Ensure that the HTTP status interface, the REST API, and the JSON API are all disabled in production environments to prevent potential data exposure and vulnerability to attackers.

### [more_information_content]
### For more information
### [destacated]
* [Security checklist](https://docs.mongodb.com/manual/administration/security-checklist/)
* [Security configuration](https://docs.mongodb.com/manual/core/security-mongodb-configuration/#bind-ip)
### [/destacated]
### [/more_information_content]
### [/recomendations_content]
